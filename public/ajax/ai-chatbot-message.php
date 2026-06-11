<?php
/**
 * IQS FRAMEWORK CORE FILE
 *
 * READ ONLY for downstream project programmers.
 * Do not modify this file directly in template or cloned projects.
 * Custom changes must be implemented in project-specific files
 * or approved extension points.
 */
declare(strict_types=1);

ob_start();
header('Content-Type: application/json; charset=utf-8');

try {
    require_once __DIR__ . '/../includes/init.php';
    require_login();
    require_once __DIR__ . '/_helpers.php';
    require_once __DIR__ . '/../classes/Database.php';
    require_once __DIR__ . '/../classes/AiChatbotService.php';
    require_once __DIR__ . '/../classes/AiChatbotUsageRepository.php';

    $t = static function (string $key, string $fallback): string {
        $value = function_exists('__') ? __($key) : null;
        return ($value === null || $value === '' || $value === $key) ? $fallback : (string)$value;
    };

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        jsonErrorResponse($t('aiChatbot_error_invalid_method', 'Kaedah permintaan tidak sah.'), 405);
    }

    if (!isValidCsrfToken()) {
        jsonErrorResponse((string)(__('userGroup_csrf_invalid') ?: 'CSRF token tidak sah.'), 403);
    }

    $pdo = Database::getInstance('mysql')->getConnection();
    $profile = $GLOBALS['profile'] ?? [];
    $profile = is_array($profile) ? $profile : [];
    $service = new AiChatbotService();
    $usageRepository = new AiChatbotUsageRepository($pdo);
    $loginId = trim((string)($_SESSION['f_loginID'] ?? $_SESSION['user']['f_loginID'] ?? ($profile['f_loginID'] ?? '')));
    $userId = $_SESSION['user']['f_userID'] ?? $_SESSION['f_userID'] ?? ($profile['f_userID'] ?? null);
    $publicConfig = $service->publicConfig();

    if (!$service->isEnabled()) {
        jsonErrorResponse($t('aiChatbot_error_disabled', 'AI Chatbot belum diaktifkan.'), 403);
    }
    if (!$service->canAccess($profile, $pdo)) {
        jsonErrorResponse($t('aiChatbot_error_forbidden', 'Anda tidak dibenarkan menggunakan AI Chatbot prototype.'), 403);
    }

    if (!checkRateLimit('ai_chatbot_message', $service->rateLimitPerMinute(), 60)) {
        ai_chatbot_record_usage_safe($service, $usageRepository, [
            'user_id' => $userId,
            'login_id' => $loginId,
            'provider' => $publicConfig['provider'] ?? 'unknown',
            'model' => $publicConfig['model'] ?? 'unknown',
            'outcome' => 'rate_limited',
            'error_code' => 'session_rate_limit',
            'error_message' => 'Per-minute session rate limit triggered.',
            'request_meta' => ['limit_per_minute' => $service->rateLimitPerMinute()],
        ]);
        if (function_exists('audit_event')) {
            audit_event([
                'event_type' => 'AI_CHATBOT_RATE_LIMIT',
                'severity' => 'WARN',
                'outcome' => 'DENIED',
                'target_type' => 'ai_chatbot',
                'target_id' => 'prototype',
                'target_label' => 'AI Chatbot Prototype',
                'message' => 'AI chatbot rate limit triggered',
                'user_id' => $_SESSION['user']['f_userID'] ?? $_SESSION['f_userID'] ?? $_SESSION['f_stafID'] ?? null,
                'actor_label' => $_SESSION['user']['f_nama'] ?? $_SESSION['f_nama'] ?? null,
                'meta' => ['limit_per_minute' => $service->rateLimitPerMinute()],
            ]);
        }
        jsonErrorResponse($t('aiChatbot_error_rate_limit', 'Terlalu banyak permintaan. Sila cuba semula sebentar lagi.'), 429);
    }

    $raw = file_get_contents('php://input');
    $data = json_decode((string)$raw, true);
    if (!is_array($data)) {
        $data = $_POST;
    }

    $message = trim((string)($data['message'] ?? ''));
    if ($message === '') {
        jsonErrorResponse($t('aiChatbot_error_empty_message', 'Sila masukkan mesej.'), 422);
    }

    if (mb_strlen($message, 'UTF-8') > $service->maxInputChars()) {
        jsonErrorResponse($t('aiChatbot_error_long_message', 'Mesej terlalu panjang.'), 422);
    }

    $userDailyLimit = $service->userDailyRequestLimit();
    if ($userDailyLimit > 0 && $loginId !== '' && $usageRepository->countToday($loginId) >= $userDailyLimit) {
        ai_chatbot_record_usage_safe($service, $usageRepository, [
            'user_id' => $userId,
            'login_id' => $loginId,
            'provider' => $publicConfig['provider'] ?? 'unknown',
            'model' => $publicConfig['model'] ?? 'unknown',
            'outcome' => 'rate_limited',
            'error_code' => 'user_daily_limit',
            'error_message' => 'Daily user request limit reached.',
            'request_meta' => ['limit' => $userDailyLimit],
        ]);
        jsonErrorResponse($t('aiChatbot_error_rate_limit', 'Terlalu banyak permintaan. Sila cuba semula sebentar lagi.'), 429);
    }

    $globalDailyLimit = $service->globalDailyRequestLimit();
    if ($globalDailyLimit > 0 && $usageRepository->countToday() >= $globalDailyLimit) {
        ai_chatbot_record_usage_safe($service, $usageRepository, [
            'user_id' => $userId,
            'login_id' => $loginId,
            'provider' => $publicConfig['provider'] ?? 'unknown',
            'model' => $publicConfig['model'] ?? 'unknown',
            'outcome' => 'rate_limited',
            'error_code' => 'global_daily_limit',
            'error_message' => 'Daily global request limit reached.',
            'request_meta' => ['limit' => $globalDailyLimit],
        ]);
        jsonErrorResponse($t('aiChatbot_error_rate_limit', 'Terlalu banyak permintaan. Sila cuba semula sebentar lagi.'), 429);
    }

    $actor = [
        'lang' => (string)($_SESSION['lang'] ?? 'ms'),
        'role' => (string)($_SESSION['group_active_name'] ?? ($profile['f_groupName'] ?? '')),
    ];

    $result = $service->sendMessage($message, $actor);
    ai_chatbot_record_usage_safe($service, $usageRepository, [
        'user_id' => $userId,
        'login_id' => $loginId,
        'provider' => $result['provider'] ?? ($publicConfig['provider'] ?? 'unknown'),
        'model' => $result['model'] ?? ($publicConfig['model'] ?? 'unknown'),
        'latency_ms' => $result['latency_ms'] ?? null,
        'outcome' => 'success',
        'usage' => is_array($result['usage'] ?? null) ? $result['usage'] : [],
        'request_meta' => [
            'message_length' => mb_strlen($message, 'UTF-8'),
            'access_mode' => $publicConfig['access_mode'] ?? null,
        ],
    ]);

    if (function_exists('audit_event')) {
        $meta = [
            'provider' => $result['provider'] ?? null,
            'model' => $result['model'] ?? null,
            'latency_ms' => $result['latency_ms'] ?? null,
            'message_length' => mb_strlen($message, 'UTF-8'),
        ];
        audit_event([
            'event_type' => 'AI_CHATBOT_MESSAGE',
            'severity' => 'INFO',
            'outcome' => 'SUCCESS',
            'target_type' => 'ai_chatbot',
            'target_id' => 'prototype',
            'target_label' => 'AI Chatbot Prototype',
            'message' => 'AI chatbot message completed',
            'user_id' => $_SESSION['user']['f_userID'] ?? $_SESSION['f_userID'] ?? $_SESSION['f_stafID'] ?? null,
            'actor_label' => $_SESSION['user']['f_nama'] ?? $_SESSION['f_nama'] ?? null,
            'meta' => $meta,
        ]);
    }

    jsonSuccessResponse([
        'message' => (string)$result['message'],
        'provider' => (string)($result['provider'] ?? ''),
        'model' => (string)($result['model'] ?? ''),
        'latency_ms' => (int)($result['latency_ms'] ?? 0),
        'usage' => is_array($result['usage'] ?? null) ? $result['usage'] : [],
    ]);
} catch (InvalidArgumentException $e) {
    error_log('[ai-chatbot-message] validation: ' . $e->getMessage());
    $fallback = function_exists('__') ? __('aiChatbot_error_invalid_action') : null;
    jsonErrorResponse(($fallback && $fallback !== 'aiChatbot_error_invalid_action') ? (string)$fallback : 'Permintaan chatbot tidak sah.', 422);
} catch (Throwable $e) {
    error_log('[ai-chatbot-message] ' . $e->getMessage());
    if (isset($service, $usageRepository)) {
        ai_chatbot_record_usage_safe($service, $usageRepository, [
            'user_id' => $userId ?? null,
            'login_id' => $loginId ?? null,
            'provider' => $publicConfig['provider'] ?? 'unknown',
            'model' => $publicConfig['model'] ?? 'unknown',
            'outcome' => str_contains(strtolower($e->getMessage()), 'timed out') ? 'timeout' : 'failed',
            'error_code' => get_class($e),
            'error_message' => $e->getMessage(),
        ]);
    }
    if (function_exists('audit_event')) {
        audit_event([
            'event_type' => 'AI_CHATBOT_MESSAGE',
            'severity' => 'ERROR',
            'outcome' => 'FAIL',
            'target_type' => 'ai_chatbot',
            'target_id' => 'prototype',
            'target_label' => 'AI Chatbot Prototype',
            'message' => 'AI chatbot message failed',
            'user_id' => $_SESSION['user']['f_userID'] ?? $_SESSION['f_userID'] ?? $_SESSION['f_stafID'] ?? null,
            'actor_label' => $_SESSION['user']['f_nama'] ?? $_SESSION['f_nama'] ?? null,
            'meta' => [
                'error_class' => get_class($e),
                'error_message' => $e->getMessage(),
            ],
        ]);
    }
    $fallback = function_exists('__') ? __('aiChatbot_error_generic') : null;
    jsonErrorResponse(($fallback && $fallback !== 'aiChatbot_error_generic') ? (string)$fallback : 'AI Chatbot tidak dapat menjawab buat masa ini.', 500);
}

/**
 * @param array<string,mixed> $row
 */
function ai_chatbot_record_usage_safe(AiChatbotService $service, AiChatbotUsageRepository $repository, array $row): void
{
    if (!$service->shouldPersistUsage()) {
        return;
    }

    try {
        $repository->record($row);
    } catch (Throwable $e) {
        error_log('[ai-chatbot-usage] ' . $e->getMessage());
    }
}
