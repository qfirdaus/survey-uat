<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';
require_login();

$tables = [];
$errorMessage = null;

try {
    // Gunakan konfigurasi Sybase Student Development daripada
    // configuration/db_config.php dan credentials daripada .env.
    // DatabaseManager akan memilih PDO ODBC atau DBLIB yang tersedia.
    $pdo = Database::getInstance('sybase_student_dev')->getConnection();

    $objects = $pdo->query(
        "SELECT user_name(uid) AS owner_name, name AS table_name
         FROM sysobjects
         WHERE type = 'U'
         ORDER BY name"
    )->fetchAll(PDO::FETCH_ASSOC);

    foreach ($objects as $object) {
        $owner = trim((string)($object['owner_name'] ?? ''));
        $tableName = trim((string)($object['table_name'] ?? ''));

        // Padankan teks literal "survey_", bukan underscore wildcard SQL.
        if (stripos($tableName, 'survey_') === false) {
            continue;
        }

        // Nama datang daripada system catalog, tetapi tetap disahkan sebelum
        // digunakan sebagai identifier dalam query COUNT.
        if (
            preg_match('/^[A-Za-z0-9_]+$/', $owner) !== 1
            || preg_match('/^[A-Za-z0-9_]+$/', $tableName) !== 1
        ) {
            continue;
        }

        $qualifiedName = $owner . '.' . $tableName;
        try {
            $countResult = $pdo->query(
                "SELECT COUNT(*) AS total FROM {$qualifiedName}"
            )->fetch(PDO::FETCH_ASSOC);

            $tables[] = [
                'name' => $qualifiedName,
                'total' => (int)($countResult['total'] ?? 0),
                'error' => null,
            ];
        } catch (Throwable $tableError) {
            error_log(
                "Count failed for {$qualifiedName}: " . $tableError->getMessage()
            );
            $tables[] = [
                'name' => $qualifiedName,
                'total' => null,
                'error' => 'Gagal membaca table',
            ];
        }
    }
} catch (Throwable $e) {
    error_log('Sybase Student test page failed: ' . $e->getMessage());
    $errorMessage = 'Sambungan atau query ke Sybase Student Development gagal. Sila semak konfigurasi database dan log aplikasi.';
}

$escape = static fn(mixed $value): string =>
    htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
?>

<div class="container py-4">
    <h2>Ujian Data Sybase Student</h2>
    <p class="text-muted">Environment: Development</p>

    <?php if ($errorMessage !== null): ?>
        <div class="alert alert-danger" role="alert">
            <?= $escape($errorMessage) ?>
        </div>
    <?php else: ?>
        <div class="alert alert-success" role="status">
            Sambungan ke Sybase berjaya. Jumlah table ditemui:
            <strong><?= $escape(count($tables)) ?></strong>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama table</th>
                        <th class="text-end">Jumlah data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($tables === []): ?>
                        <tr>
                            <td colspan="3" class="text-muted">
                                Tiada table yang mengandungi nama "survey_" ditemui.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($tables as $index => $table): ?>
                            <tr>
                                <td><?= $escape($index + 1) ?></td>
                                <td><?= $escape($table['name'] ?? '') ?></td>
                                <td class="text-end">
                                    <?php if (($table['error'] ?? null) !== null): ?>
                                        <span class="text-danger">
                                            <?= $escape($table['error']) ?>
                                        </span>
                                    <?php else: ?>
                                        <?= $escape(number_format((int)($table['total'] ?? 0))) ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
