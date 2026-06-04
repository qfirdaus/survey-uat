<?php
/**
 * IQS FRAMEWORK CORE FILE
 *
 * READ ONLY for downstream project programmers.
 * Do not modify this file directly in template or cloned projects.
 * Custom changes must be implemented in project-specific files
 * or approved extension points.
 */declare(strict_types=1);

ob_start();
header('Content-Type: application/json; charset=utf-8');

try {
    require_once __DIR__ . '/../includes/init.php';
    require_login();
    require_once __DIR__ . '/_helpers.php';
    require_once __DIR__ . '/../classes/Database.php';
    require_once __DIR__ . '/../classes/NotificationTemplateService.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        jsonErrorResponse((string)(__('notification_invalid_method') ?: 'Invalid request method.'), 405);
    }

    if (!isValidCsrfToken()) {
        jsonErrorResponse((string)(__('userGroup_csrf_invalid') ?: 'Invalid CSRF token.'), 403);
    }

    $pdo = Database::getInstance('mysql')->getConnection();
    ensureAjaxGroupManagePermission($pdo, (string)(__('notification_template_forbidden') ?: 'You do not have permission to manage notification templates.'));

    $raw = file_get_contents('php://input');
    $data = json_decode((string)$raw, true);
    if (!is_array($data)) {
        $data = $_POST;
    }

    $action = strtolower(trim((string)($data['action'] ?? 'save')));
    $service = new NotificationTemplateService($pdo);
    $updateBy = (string)($_SESSION['f_loginID'] ?? $_SESSION['f_stafID'] ?? 'admin');
    $message = '';

    if ($action === 'save') {
        $templateId = $service->save($data, $updateBy);
        $message = (string)(__('notification_template_save_success') ?: 'Notification template saved.');
    } elseif ($action === 'duplicate') {
        $templateId = $service->duplicate((int)($data['template_id'] ?? 0), $updateBy);
        $message = (string)(__('notification_template_duplicate_success') ?: 'Notification template duplicated.');
    } elseif ($action === 'archive') {
        $templateId = (int)($data['template_id'] ?? 0);
        $service->archive($templateId, $updateBy);
        $message = (string)(__('notification_template_archive_success') ?: 'Notification template archived.');
    } elseif ($action === 'restore') {
        $templateId = (int)($data['template_id'] ?? 0);
        $service->restore($templateId, $updateBy);
        $message = (string)(__('notification_template_restore_success') ?: 'Notification template restored.');
    } elseif ($action === 'delete') {
        $templateId = (int)($data['template_id'] ?? 0);
        $service->delete($templateId);
        $message = (string)(__('notification_template_delete_success') ?: 'Notification template deleted.');
    } else {
        jsonErrorResponse((string)(__('notification_template_invalid_action') ?: 'Invalid template action.'), 422);
    }

    jsonSuccessResponse([
        'message' => $message,
        'template_id' => $templateId ?? 0,
        'records' => $service->getAll(),
        'summary' => $service->summary(),
    ]);
} catch (InvalidArgumentException|RuntimeException $e) {
    jsonErrorResponse($e->getMessage(), 422);
} catch (Throwable $e) {
    error_log('[notification-template-action] ' . $e->getMessage());
    jsonErrorResponse((string)(__('notification_template_save_failed') ?: 'Unable to save notification template.'), 500);
}
