<?php
/**
 * IQS FRAMEWORK CORE FILE
 *
 * READ ONLY for downstream project programmers.
 * Do not modify this file directly in template or cloned projects.
 * Custom changes must be implemented in project-specific files
 * or approved extension points.
 */// ajax/group-list.php
declare(strict_types=1);
require_once __DIR__ . '/../includes/init.php';
require_login();
require_once __DIR__ . '/_helpers.php';
require_once __DIR__ . '/../includes/functions-db.php';
header('Content-Type: application/json; charset=utf-8');

function group_is_system_protected(array $group): bool {
    $groupId = (int)($group['id'] ?? $group['f_groupID'] ?? 0);
    $groupKod = strtoupper(trim((string)($group['kod'] ?? $group['f_groupKod'] ?? '')));
    $saId = defined('PRESTASI_ROLE_ID_ADM_SA') ? (int)PRESTASI_ROLE_ID_ADM_SA : 0;
    $saCode = defined('PRESTASI_ROLE_KOD_ADM_SA')
        ? strtoupper(trim((string)PRESTASI_ROLE_KOD_ADM_SA))
        : (defined('PRESTASI_ROLE_ADM_SA') ? strtoupper(trim((string)PRESTASI_ROLE_ADM_SA)) : 'ADM-SA');

    return ($saId > 0 && $groupId === $saId) || ($groupKod !== '' && $groupKod === $saCode);
}

function group_category_for_scope(string $scope): ?string {
    return match (strtolower(trim($scope))) {
        'staff', 'staf' => 'STAF',
        'student', 'pelajar' => 'PELAJAR',
        'public', 'umum' => 'UMUM',
        default => null,
    };
}

function group_table_column_exists(PDO $pdo, string $column): bool {
    static $cache = [];
    $cacheKey = strtolower($column);
    if (array_key_exists($cacheKey, $cache)) {
        return $cache[$cacheKey];
    }

    try {
        $databaseName = (string)$pdo->query('SELECT DATABASE()')->fetchColumn();
        if ($databaseName === '') {
            return $cache[$cacheKey] = false;
        }

        $stmt = $pdo->prepare(
            'SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
             WHERE TABLE_SCHEMA = :database
               AND TABLE_NAME = :table
               AND COLUMN_NAME = :column'
        );
        $stmt->execute([
            ':database' => $databaseName,
            ':table' => 'tbl_m_group',
            ':column' => $column,
        ]);
        return $cache[$cacheKey] = ((int)$stmt->fetchColumn()) > 0;
    } catch (Throwable $e) {
        return $cache[$cacheKey] = false;
    }
}

function group_optional_select(PDO $pdo, string $column, string $alias, string $defaultSql): string {
    return group_table_column_exists($pdo, $column)
        ? "COALESCE($column, $defaultSql) AS $alias"
        : "$defaultSql AS $alias";
}

try {
    // Konsisten dengan modul-list.php
    $db = Database::getInstance('mysql')->getConnection();
    ensureAjaxGroupManagePermission($db);

    $scope = strtolower(trim((string)($_GET['scope'] ?? 'staff')));
    $groupID = (int)($_GET['groupID'] ?? 0);
    $category = group_category_for_scope($scope);
    if ($category === 'PELAJAR' && function_exists('is_student_mode_enabled') && !is_student_mode_enabled()) {
        http_response_code(403);
        echo json_encode(['error' => true, 'message' => (string)__('studentSearch_mode_disabled')], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Jika ada lajur penanda aktif (contoh f_flag), boleh aktifkan WHERE di bawah:
    $where = '1=1';
    $params = [];
    if ($groupID > 0) {
        $where .= ' AND f_groupID = :groupID';
        $params[':groupID'] = $groupID;
    } elseif ($category !== null) {
        $where .= ' AND TRIM(COALESCE(f_categoryUser, \'\')) = :category';
        $params[':category'] = $category;
    }
    // $where = 'COALESCE(f_flag,1)=1'; // uncomment jika jadual ada f_flag

    $select = [
        'f_groupID   AS id',
        'f_groupKod  AS kod',
        'f_groupName AS nama',
        'f_categoryUser AS categoryUser',
        group_optional_select($db, 'f_modulAccess', 'modulAccess', "''"),
        group_optional_select($db, 'f_menuAccess', 'menuAccess', "''"),
        group_optional_select($db, 'f_color', 'color', "''"),
        group_optional_select($db, 'f_priority', 'priority', '0'),
        group_optional_select($db, 'f_mod', 'mod', '0'),
        group_optional_select($db, 'f_badge_class', 'badgeClass', "''"),
        group_optional_select($db, 'f_row_class', 'rowClass', "''"),
        '(SELECT COUNT(*) FROM tbl_m_user u WHERE u.f_groupID = tbl_m_group.f_groupID) AS userCount',
    ];

    $sql = "
      SELECT
        " . implode(",\n        ", $select) . "
      FROM tbl_m_group
      WHERE $where
      ORDER BY f_groupKod ASC, f_groupName ASC, f_groupID ASC
    ";

    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

    // (Opsyenal) pastikan id integer
    foreach ($rows as &$r) {
        if (isset($r['id'])) $r['id'] = (int)$r['id'];
        $r['modulAccess'] = array_values(array_filter(array_map('trim', explode(',', (string)($r['modulAccess'] ?? ''))), static fn($v) => $v !== ''));
        $r['menuAccess'] = array_values(array_filter(array_map('trim', explode(',', (string)($r['menuAccess'] ?? ''))), static fn($v) => $v !== ''));
        $r['priority'] = (int)($r['priority'] ?? 0);
        $r['mod'] = (int)($r['mod'] ?? 0);
        $r['userCount'] = (int)($r['userCount'] ?? 0);
        $hasAccess = !empty($r['modulAccess']) || !empty($r['menuAccess']);
        $r['canDelete'] = !$hasAccess && $r['userCount'] === 0 && !group_is_system_protected($r);
    }

    $payload = ['error' => false, 'groups' => $rows];
    if ($groupID > 0) {
        $payload['group'] = $rows[0] ?? null;
    }
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(
        ['error' => true, 'message' => 'Ralat server: ' . $e->getMessage()],
        JSON_UNESCAPED_UNICODE
    );
}
