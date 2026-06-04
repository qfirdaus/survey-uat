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

try {
    $groupId = (int)($_GET['group_id'] ?? 0);
    if ($groupId <= 0) {
        http_response_code(400);
        exit('Invalid request.');
    }

    $activeGroupId = (int)($_SESSION['group_active_id'] ?? 0);
    $db = Database::getInstance()->getConnection();
    $stmt = $db->prepare("SELECT f_groupKod FROM tbl_m_group WHERE f_groupID = ?");
    $stmt->execute([$activeGroupId]);
    $roleKod = (string)$stmt->fetchColumn();
    $isAdmin = manual_is_admin_role((string)$roleKod);

    if (!$isAdmin && $groupId !== $activeGroupId) {
        http_response_code(403);
        exit('Forbidden.');
    }

    $controller = new ManualController();
    $manual = $controller->getManualByGroupId($groupId);
    $relativePath = (string)($manual['f_file_path'] ?? '');
    if ($relativePath === '') {
        http_response_code(404);
        exit('File not found.');
    }

    $fullPath = realpath(__DIR__ . '/../' . ltrim($relativePath, '/\\'));
    $baseDir = realpath(__DIR__ . '/../uploads/manuals');
    if ($fullPath === false || $baseDir === false || strncmp($fullPath, $baseDir, strlen($baseDir)) !== 0 || !is_file($fullPath)) {
        http_response_code(404);
        exit('File not found.');
    }

    header('Content-Type: application/pdf');
    header('Content-Length: ' . (string)filesize($fullPath));
    header('Content-Disposition: inline; filename="' . basename($fullPath) . '"');
    header('X-Content-Type-Options: nosniff');
    header('Cache-Control: private, no-store, no-cache, must-revalidate');
    header('Pragma: no-cache');

    readfile($fullPath);
    exit;
} catch (Throwable $e) {
    http_response_code(500);
    exit('Unable to load file.');
}
