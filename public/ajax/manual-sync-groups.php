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
require_once __DIR__ . '/../setting/constants/manual_constants.php';
require_once __DIR__ . '/../controllers/ManualController.php';

header('Content-Type: application/json; charset=utf-8');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['error' => true, 'message' => __('manual_method_not_allowed')], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $headers = function_exists('getallheaders') ? (getallheaders() ?: []) : [];
    $csrfHdr = $headers['X-CSRF-Token'] ?? $headers['x-csrf-token'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');
    $csrfSession = (string)($_SESSION['csrf_token'] ?? '');
    if ($csrfSession === '' || !hash_equals($csrfSession, (string)$csrfHdr)) {
        http_response_code(400);
        echo json_encode(['error' => true, 'message' => __('manual_csrf_invalid')], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $activeGroupId = (int)($_SESSION['group_active_id'] ?? 0);
    $db = Database::getInstance()->getConnection();
    $stmt = $db->prepare("SELECT f_groupKod FROM tbl_m_group WHERE f_groupID = ?");
    $stmt->execute([$activeGroupId]);
    $roleKod = $stmt->fetchColumn();

    if (!manual_is_admin_role((string)$roleKod)) {
        http_response_code(403);
        echo json_encode(['error' => true, 'message' => __('manual_action_forbidden')], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $controller = new ManualController();
    $result = $controller->syncManualGroups();

    echo json_encode([
        'error' => !($result['success'] ?? false),
        'message' => (string)($result['message'] ?? '')
    ], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => true, 'message' => __('manual_server_sync_error')], JSON_UNESCAPED_UNICODE);
}
