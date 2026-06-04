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
    require_once __DIR__ . '/../classes/NotificationService.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        jsonErrorResponse((string)(__('notification_invalid_method') ?: 'Kaedah permintaan tidak sah.'), 405);
    }

    if (!isValidCsrfToken()) {
        jsonErrorResponse((string)(__('userGroup_csrf_invalid') ?: 'CSRF token tidak sah.'), 403);
    }

    $raw = file_get_contents('php://input');
    $data = json_decode((string)$raw, true);
    if (!is_array($data)) {
        $data = [];
    }

    $limit = max(1, min(500, (int)($data['limit'] ?? 100)));
    $service = new NotificationService(Database::getInstance('mysql')->getConnection());
    $actor = $service->resolveCurrentActor();
    $updated = $service->markAllAsRead($actor, $limit);

    jsonSuccessResponse([
        'updated' => $updated,
        'unread' => $service->countUnread($actor),
        'message' => (string)(__('topbar_notification_read_all_success') ?: 'All notifications marked as read.'),
    ]);
} catch (Throwable $e) {
    error_log('[notification-read-all] ' . $e->getMessage());
    jsonErrorResponse((string)(__('topbar_notification_read_all_failed') ?: 'Gagal menanda semua notifikasi sebagai dibaca.'), 500);
}
