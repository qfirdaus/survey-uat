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

require_once __DIR__ . '/AiChatbotProviderRegistry.php';
require_once __DIR__ . '/SystemConfigConstants.php';

final class AiChatbotService
{
    /** @var array<string,mixed> */
    private array $config;

    public function __construct(?array $config = null)
    {
        $this->config = $config ?? self::loadConfig();
    }

    /**
     * @return array<string,mixed>
     */
    public static function loadConfig(): array
    {
        $config = [
            'enabled' => false,
            'provider' => 'ollama',
            'model' => 'llama3.2:3b',
            'base_url' => 'http://127.0.0.1:11434',
            'api_key' => '',
            'timeout_seconds' => 30,
            'max_input_chars' => 2000,
            'max_output_tokens' => 800,
            'rate_limit_per_minute' => 10,
            'user_daily_request_limit' => 100,
            'global_daily_request_limit' => 1000,
            'persist_usage' => true,
            'store_conversations' => false,
            'log_message_content' => false,
            'character_name' => 'IQS Assistant',
            'character_avatar' => 'assets/images/ai/assistant.png',
            'welcome_message' => 'Hai, saya boleh bantu tentang penggunaan sistem ini.',
            'access_mode' => 'super_admin_only',
            'allowed_groups' => '',
            'app_url' => 'https://iqs-framework.dev',
            'app_title' => 'IQS-Framework AI Chatbot',
        ];

        foreach (self::loadDbConfigOverrides() as $key => $value) {
            if (!array_key_exists($key, $config)) {
                continue;
            }
            $config[$key] = $value;
        }

        return self::normalizeConfig($config);
    }

    /**
     * @return array<string,mixed>
     */
    public function publicConfig(): array
    {
        return [
            'enabled' => (bool)$this->config['enabled'],
            'provider' => (string)$this->config['provider'],
            'model' => (string)$this->config['model'],
            'base_url' => (string)$this->config['base_url'],
            'character_name' => (string)$this->config['character_name'],
            'character_avatar' => (string)$this->config['character_avatar'],
            'welcome_message' => (string)$this->config['welcome_message'],
            'access_mode' => (string)$this->config['access_mode'],
            'allowed_groups' => (string)$this->config['allowed_groups'],
            'rate_limit_per_minute' => (int)$this->config['rate_limit_per_minute'],
            'user_daily_request_limit' => (int)$this->config['user_daily_request_limit'],
            'global_daily_request_limit' => (int)$this->config['global_daily_request_limit'],
            'persist_usage' => (bool)$this->config['persist_usage'],
            'store_conversations' => (bool)$this->config['store_conversations'],
            'log_message_content' => (bool)$this->config['log_message_content'],
        ];
    }

    public function isEnabled(): bool
    {
        return (bool)$this->config['enabled'];
    }

    public function rateLimitPerMinute(): int
    {
        return max(1, (int)$this->config['rate_limit_per_minute']);
    }

    public function maxInputChars(): int
    {
        return max(1, (int)$this->config['max_input_chars']);
    }

    public function userDailyRequestLimit(): int
    {
        return max(0, (int)$this->config['user_daily_request_limit']);
    }

    public function globalDailyRequestLimit(): int
    {
        return max(0, (int)$this->config['global_daily_request_limit']);
    }

    public function shouldPersistUsage(): bool
    {
        return (bool)$this->config['persist_usage'];
    }

    /**
     * @param array<string,mixed> $profile
     */
    public function canAccess(array $profile = [], ?PDO $pdo = null, bool $requireEnabled = true): bool
    {
        if ($requireEnabled && !$this->isEnabled()) {
            return false;
        }

        $mode = strtolower(trim((string)($this->config['access_mode'] ?? 'super_admin_only')));
        if ($mode === 'all_authenticated') {
            return !empty($_SESSION['f_stafID'])
                || !empty($_SESSION['f_loginID'])
                || !empty($_SESSION['user']);
        }

        $isSuperAdmin = function_exists('is_user_super_admin') && $pdo instanceof PDO
            ? is_user_super_admin($profile, $pdo)
            : false;

        if ($mode === 'super_admin_only') {
            return $isSuperAdmin;
        }

        if ($mode === 'selected_groups') {
            if ($isSuperAdmin) {
                return true;
            }

            $allowed = $this->allowedGroupTokens();
            if ($allowed === []) {
                return false;
            }

            $active = function_exists('prestasi_resolve_active_group') && $pdo instanceof PDO
                ? prestasi_resolve_active_group($profile, $pdo)
                : [
                    'id' => (int)($_SESSION['group_active_id'] ?? ($profile['f_groupID'] ?? 0)),
                    'kod' => (string)($profile['f_groupKod'] ?? ''),
                ];

            $groupId = (string)((int)($active['id'] ?? 0));
            $groupCode = strtoupper(trim((string)($active['kod'] ?? '')));

            return ($groupId !== '0' && in_array($groupId, $allowed, true))
                || ($groupCode !== '' && in_array($groupCode, $allowed, true));
        }

        return false;
    }

    /**
     * @return array<int,string>
     */
    private function allowedGroupTokens(): array
    {
        $raw = strtoupper(trim((string)($this->config['allowed_groups'] ?? '')));
        if ($raw === '') {
            return [];
        }

        $parts = preg_split('/\s*,\s*/', $raw) ?: [];
        $tokens = [];
        foreach ($parts as $part) {
            $part = trim((string)$part);
            if ($part !== '') {
                $tokens[] = $part;
            }
        }

        return array_values(array_unique($tokens));
    }

    /**
     * @param array<string,mixed> $actor
     * @return array<string,mixed>
     */
    public function sendMessage(string $message, array $actor = []): array
    {
        $message = trim($message);
        if ($message === '') {
            throw new InvalidArgumentException('Message is required.');
        }

        if (mb_strlen($message, 'UTF-8') > $this->maxInputChars()) {
            throw new InvalidArgumentException('Message is too long.');
        }

        if (!$this->isEnabled()) {
            throw new RuntimeException('AI chatbot is disabled.');
        }

        $provider = AiChatbotProviderRegistry::resolve($this->config);
        $messages = [
            [
                'role' => 'system',
                'content' => $this->systemPrompt($actor),
            ],
            [
                'role' => 'user',
                'content' => $message,
            ],
        ];

        return $provider->send($messages, [
            'temperature' => 0.3,
        ]);
    }

    /**
     * @param array<string,mixed> $actor
     */
    private function systemPrompt(array $actor): string
    {
        $lang = trim((string)($actor['lang'] ?? ($_SESSION['lang'] ?? 'ms')));
        $role = trim((string)($actor['role'] ?? ''));

        $parts = [
            'You are the IQS-Framework internal assistant.',
            'Answer in the user language where possible. If the user writes Malay, answer in Malay.',
            'Be concise, practical, and honest.',
            'Do not claim you have performed system actions.',
            'Do not request or reveal passwords, tokens, cookies, CSRF tokens, API keys, or internal configuration.',
            'This prototype is read-only. Do not offer database writes, permission changes, or account changes.',
        ];

        if ($lang !== '') {
            $parts[] = 'Current user language: ' . $lang . '.';
        }

        if ($role !== '') {
            $parts[] = 'Current user role label: ' . $role . '.';
        }

        return implode("\n", $parts);
    }

    /**
     * @return array<string,mixed>
     */
    private static function loadDbConfigOverrides(): array
    {
        try {
            require_once __DIR__ . '/Database.php';
            require_once __DIR__ . '/Config.php';

            $pdo = Database::getInstance('mysql')->getConnection();
            $configModel = new Config($pdo);
            $group = $configModel->getGroup(SystemConfigConstants::CONFIG_GROUP_AI_CHATBOT);

            return is_array($group) ? $group : [];
        } catch (Throwable $e) {
            return [];
        }
    }

    /**
     * @param array<string,mixed> $config
     * @return array<string,mixed>
     */
    private static function normalizeConfig(array $config): array
    {
        foreach ([
            'enabled',
            'persist_usage',
            'store_conversations',
            'log_message_content',
        ] as $key) {
            $config[$key] = self::normalizeBoolValue($config[$key] ?? false);
        }

        foreach ([
            'timeout_seconds',
            'max_input_chars',
            'max_output_tokens',
            'rate_limit_per_minute',
            'user_daily_request_limit',
            'global_daily_request_limit',
        ] as $key) {
            $config[$key] = (int)($config[$key] ?? 0);
        }

        foreach ($config as $key => $value) {
            if (!is_bool($value) && !is_int($value)) {
                $config[$key] = trim((string)$value);
            }
        }

        return $config;
    }

    private static function normalizeBoolValue(mixed $value): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        return in_array(strtolower(trim((string)$value)), ['1', 'true', 'yes', 'on'], true);
    }

}
