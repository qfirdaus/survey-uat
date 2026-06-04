<?php
/**
 * IQS FRAMEWORK CORE FILE
 *
 * READ ONLY for downstream project programmers.
 * Do not modify this file directly in template or cloned projects.
 * Custom changes must be implemented in project-specific files
 * or approved extension points.
 */declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';
require_login();
require_once __DIR__ . '/_helpers.php';
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/SystemCacheMaintenanceService.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $pdo = Database::getInstance('mysql')->getConnection();
    ensureAjaxGroupManagePermission($pdo, (string)(__('systemCache_forbidden') ?: 'You do not have permission to clear system cache.'));

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        jsonErrorResponse((string)(__('systemCache_error_invalid_method') ?: 'Invalid request method.'), 405);
    }

    if (!isValidCsrfToken()) {
        jsonErrorResponse((string)(__('userGroup_csrf_invalid') ?: 'Invalid CSRF token.'), 403);
    }

    $action = trim((string)($_POST['action'] ?? ''));
    if ($action !== 'clear') {
        jsonErrorResponse((string)(__('systemCache_error_invalid_action') ?: 'Invalid cache action.'), 422);
    }

    $scope = trim((string)($_POST['scope'] ?? 'selected'));
    $clearAll = $scope === 'all';
    $selectedIds = $_POST['locations'] ?? [];
    if (!is_array($selectedIds)) {
        $selectedIds = [];
    }
    $selectedIds = array_values(array_filter(array_map('strval', $selectedIds)));

    if (!$clearAll && $selectedIds === []) {
        jsonErrorResponse((string)(__('systemCache_error_no_selection') ?: 'Select at least one cache location.'), 422);
    }

    $service = new SystemCacheMaintenanceService();
    $result = $service->clear($selectedIds, $clearAll);

    if (function_exists('audit_event')) {
        audit_event([
            'event_type' => 'DELETE',
            'severity' => 'WARN',
            'outcome' => empty($result['errors']) ? 'SUCCESS' : 'PARTIAL',
            'target_type' => 'system_cache',
            'target_id' => 'system-cache',
            'target_label' => 'System Cache Maintenance',
            'message' => 'System cache cleared',
            'user_id' => $_SESSION['user']['f_userID'] ?? $_SESSION['f_userID'] ?? $_SESSION['f_stafID'] ?? null,
            'actor_label' => $_SESSION['user']['f_nama'] ?? $_SESSION['f_nama'] ?? null,
            'meta' => [
                'scope' => $clearAll ? 'all' : 'selected',
                'locations_cleared' => $result['locations_cleared'],
                'files_removed' => $result['files_removed'],
                'freed_bytes' => $result['freed_bytes'],
                'freed_size' => $result['freed_size'],
                'opcache' => $result['opcache'],
                'apcu' => $result['apcu'],
                'errors' => $result['errors'],
            ],
        ]);
    }

    jsonSuccessResponse([
        'message' => (string)(__('systemCache_success_message') ?: 'System cache cleared successfully.'),
        'result' => $result,
        'note' => (string)(__('systemCache_success_note') ?: 'Users do not need to logout/login after clearing cache. A page refresh is normally sufficient.'),
    ]);
} catch (Throwable $e) {
    error_log('[system-cache-action] ' . $e->getMessage());
    jsonErrorResponse((string)(__('systemCache_error_generic') ?: 'Unable to clear system cache.'), 500);
}
