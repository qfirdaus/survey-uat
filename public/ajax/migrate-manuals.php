<?php
/**
 * IQS FRAMEWORK CORE FILE
 *
 * READ ONLY for downstream project programmers.
 * Do not modify this file directly in template or cloned projects.
 * Custom changes must be implemented in project-specific files
 * or approved extension points.
 */// Standalone migration - no init.php, no session, no redirect
try {
    $pdo = new PDO(
        'mysql:host=172.16.2.141;dbname=upnm30db;charset=utf8mb4',
        'dm_system',
        'dm_System@2025?',
        [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]
    );
    
    $stmt = $pdo->query("SHOW TABLES LIKE 'tbl_m_usermanual'");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("CREATE TABLE tbl_m_usermanual (
            f_id INT AUTO_INCREMENT PRIMARY KEY,
            f_groupID INT NOT NULL UNIQUE,
            f_file_path VARCHAR(255) NOT NULL,
            f_updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            f_updated_by VARCHAR(50) NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        echo "CREATED\n";
    } else {
        echo "EXISTS\n";
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
