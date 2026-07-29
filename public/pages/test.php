<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';
require_login();

$tables = [];
$errorMessage = null;
$connectionInfo = [
    'environment' => 'Development',
    'database' => '-',
    'host' => '-',
    'port' => '-',
    'driver' => '-',
];

try {
    // Gunakan konfigurasi Sybase Student Development daripada
    // configuration/db_config.php dan credentials daripada .env.
    // DatabaseManager akan memilih PDO ODBC atau DBLIB yang tersedia.
    $pdo = Database::getInstance('sybase_student_dev')->getConnection();

    $connectionInfo['driver'] = strtoupper(
        (string)$pdo->getAttribute(PDO::ATTR_DRIVER_NAME)
    );

    $databaseResult = $pdo->query(
        'SELECT db_name() AS database_name'
    )->fetch(PDO::FETCH_ASSOC);
    $connectionInfo['database'] = trim(
        (string)($databaseResult['database_name'] ?? '-')
    );

    // Ambil host dan port daripada config DBLIB untuk paparan sahaja.
    // Username dan password tidak pernah dimasukkan dalam output.
    $databaseConfigs = require __DIR__ . '/../configuration/db_config.php';
    $devDblibDsn = (string)(
        $databaseConfigs['sybase_student_dev_dblib']['dsn'] ?? ''
    );
    if (
        preg_match(
            '/^dblib:host=([^:;]+):([0-9]+);dbname=([^;]+)/i',
            $devDblibDsn,
            $dsnParts
        ) === 1
    ) {
        $connectionInfo['host'] = trim((string)$dsnParts[1]);
        $connectionInfo['port'] = trim((string)$dsnParts[2]);
    }

    $objects = $pdo->query(
        "SELECT user_name(uid) AS owner_name, name AS table_name
         FROM sysobjects
         WHERE type = 'U'
         ORDER BY name"
    )->fetchAll(PDO::FETCH_ASSOC);

    foreach ($objects as $object) {
        $owner = trim((string)($object['owner_name'] ?? ''));
        $tableName = trim((string)($object['table_name'] ?? ''));

        // Hanya nama table yang bermula tepat dengan teks literal "survey_".
        if (stripos($tableName, 'survey_') !== 0) {
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
    <div class="mb-4">
        <h2 class="mb-1">Ujian Data Sybase Student</h2>
        <p class="text-muted mb-0">
            Senarai table yang bermula dengan <code>survey_</code>
        </p>
    </div>

    <?php if ($errorMessage !== null): ?>
        <div class="alert alert-danger" role="alert">
            <?= $escape($errorMessage) ?>
        </div>
    <?php else: ?>
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Maklumat Sambungan Database</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <tbody>
                        <tr>
                            <th class="bg-light" style="width: 18%">Environment</th>
                            <td><?= $escape($connectionInfo['environment']) ?></td>
                            <th class="bg-light" style="width: 18%">Database</th>
                            <td><strong><?= $escape($connectionInfo['database']) ?></strong></td>
                        </tr>
                        <tr>
                            <th class="bg-light">IP / Host</th>
                            <td><code><?= $escape($connectionInfo['host']) ?></code></td>
                            <th class="bg-light">Port</th>
                            <td><code><?= $escape($connectionInfo['port']) ?></code></td>
                        </tr>
                        <tr>
                            <th class="bg-light">Driver Aktif</th>
                            <td><?= $escape($connectionInfo['driver']) ?></td>
                            <th class="bg-light">Status</th>
                            <td>
                                <span class="badge bg-success">Sambungan berjaya</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Senarai Table Survey</h5>
                <span class="badge bg-primary">
                    <?= $escape(count($tables)) ?> table
                </span>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 70px" class="text-center">#</th>
                            <th>Nama Table</th>
                            <th style="width: 200px" class="text-end">Jumlah Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($tables === []): ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    Tiada table yang bermula dengan "survey_" ditemui.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($tables as $index => $table): ?>
                                <tr>
                                    <td class="text-center"><?= $escape($index + 1) ?></td>
                                    <td>
                                        <code class="fs-6"><?= $escape($table['name'] ?? '') ?></code>
                                    </td>
                                    <td class="text-end fw-semibold">
                                        <?php if (($table['error'] ?? null) !== null): ?>
                                            <span class="badge bg-danger">
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
        </div>
    <?php endif; ?>
</div>
