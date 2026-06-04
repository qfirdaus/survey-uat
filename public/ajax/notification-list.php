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

    $mode = strtolower((string)($data['mode'] ?? 'topbar'));
    $limitDefault = $mode === 'page' ? 25 : 10;
    $limitMax = $mode === 'page' ? 100 : 25;
    $limit = max(1, min($limitMax, (int)($data['limit'] ?? $limitDefault)));
    $filter = strtolower((string)($data['filter'] ?? 'all'));
    $allowedFilters = ['all', 'unread', 'read', 'action_required', 'overdue'];
    if (!in_array($filter, $allowedFilters, true)) {
        $filter = 'all';
    }

    $lang = (string)($_SESSION['lang'] ?? 'ms');
    $service = new NotificationService(Database::getInstance('mysql')->getConnection());
    $actor = $service->resolveCurrentActor();
    $items = $service->listNotifications($actor, [
        'lang' => $lang,
        'limit' => $limit,
        'mode' => $mode,
        'filter' => $filter,
    ]);

    jsonSuccessResponse([
        'unread' => $service->countUnread($actor),
        'items' => $items,
    ]);
} catch (Throwable $e) {
    error_log('[notification-list] ' . $e->getMessage());
    jsonErrorResponse((string)(__('topbar_notification_load_failed') ?: 'Tidak dapat memuatkan notifikasi.'), 500);
}
