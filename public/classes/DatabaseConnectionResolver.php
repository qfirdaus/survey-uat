<?php
/**
 * IQS FRAMEWORK CORE FILE
 *
 * READ ONLY for downstream project programmers.
 * Do not modify this file directly in template or cloned projects.
 * Custom changes must be implemented in project-specific files
 * or approved extension points.
 */declare(strict_types=1);

require_once __DIR__ . '/DatabaseRuntimeConfig.php';
require_once __DIR__ . '/DatabaseConnectionRegistry.php';

final class DatabaseConnectionResolver
{
    public function __construct(
        private readonly DatabaseRuntimeConfig $runtimeConfig,
        private readonly DatabaseConnectionRegistry $registry,
    ) {
    }

    public function resolveMainMysql(): array
    {
        $definition = $this->registry->getMain('mysql_main');
        $environment = $this->runtimeConfig->getMainMysqlEnvironment();

        return $this->resolveMysqlEnvironment($definition, $environment);
    }

    public function resolveMainSybaseStaff(): array
    {
        $definition = $this->registry->getMain('sybase_staff');
        $environment = $this->runtimeConfig->getSybaseEnvironment();

        return $this->resolveSybaseEnvironment($definition, $environment);
    }

    public function resolveMainSybaseStudent(): ?array
    {
        if (!$this->runtimeConfig->isStudentModeEnabled()) {
            return null;
        }

        $definition = $this->registry->getMain('sybase_student');
        $environment = $this->runtimeConfig->getSybaseEnvironment();

        return $this->resolveSybaseEnvironment($definition, $environment);
    }

    public function resolveAdditional(string $code, ?string $environment = null): array
    {
        $definition = $this->registry->getAdditional($code);
        if ($definition instanceof DatabaseConnectionDefinition) {
            if (!$definition->enabled) {
                throw new RuntimeException("Additional database connection is disabled: {$code}");
            }

            $targetEnvironment = $environment ?: $this->runtimeConfig->getMainMysqlEnvironment();

            if ($definition->family === 'sybase') {
                return $this->resolveSybaseEnvironment($definition, $targetEnvironment);
            }

            if ($definition->family === 'mssql') {
                return $this->resolveMssqlEnvironment($definition, $targetEnvironment);
            }

            return $this->resolveMysqlEnvironment($definition, $targetEnvironment);
        }

        $flatConfig = $this->registry->getFlatConfig($code);
        if (is_array($flatConfig)) {
            return [
                'requested_code' => $code,
                'resolved_key' => $code,
                'config' => $flatConfig,
                'fallback_key' => null,
                'fallback_config' => null,
            ];
        }

        throw new RuntimeException("Additional database connection not found: {$code}");
    }

    public function resolveByCode(string $code): array
    {
        $code = strtolower(trim($code));
        if ($code === '' || $code === 'mysql' || $code === 'mysql_main') {
            return $this->resolveMainMysql();
        }

        if ($code === 'sybase_staff') {
            return $this->resolveMainSybaseStaff();
        }

        if ($code === 'sybase_student') {
            $resolved = $this->resolveMainSybaseStudent();
            if ($resolved === null) {
                throw new RuntimeException('Sybase student runtime is disabled by operational mode.');
            }
            return $resolved;
        }

        if ($this->registry->getAdditional($code) instanceof DatabaseConnectionDefinition) {
            return $this->resolveAdditional($code);
        }

        if (str_starts_with($code, 'dbx_')) {
            return $this->resolveAdditional($code);
        }

        if ($this->registry->getFlatConfig($code) !== null) {
            if (preg_match('/^(sybase_[a-z0-9_]+)$/', $code) === 1 && !preg_match('/_(dsn|dblib|odbc|sqlsrv)$/', $code)) {
                return $this->resolveSybaseBaseKey($code);
            }

            return [
                'requested_code' => $code,
                'resolved_key' => $code,
                'config' => $this->registry->getFlatConfig($code),
                'fallback_key' => null,
                'fallback_config' => null,
            ];
        }

        if (preg_match('/^(sybase_[a-z0-9_]+)$/', $code) === 1) {
            return $this->resolveSybaseBaseKey($code);
        }

        throw new RuntimeException("Database connection not found: {$code}");
    }

    private function resolveMysqlEnvironment(DatabaseConnectionDefinition $definition, string $environment): array
    {
        $entry = $definition->environments[$environment] ?? null;
        if (!is_array($entry) || empty($entry['config'])) {
            throw new RuntimeException("MySQL environment not configured for {$definition->code}: {$environment}");
        }

        return [
            'requested_code' => $definition->code,
            'resolved_key' => (string)($entry['resolved_key'] ?? $definition->code),
            'config' => $entry['config'],
            'fallback_key' => null,
            'fallback_config' => null,
        ];
    }

    private function resolveSybaseEnvironment(DatabaseConnectionDefinition $definition, string $environment): array
    {
        $map = $definition->environments[$environment] ?? null;
        if (!is_array($map) || $map === []) {
            throw new RuntimeException("Sybase environment not configured for {$definition->code}: {$environment}");
        }

        return $this->resolveSybaseVariantMap($definition->code, $map, $definition->driverMode);
    }

    private function resolveMssqlEnvironment(DatabaseConnectionDefinition $definition, string $environment): array
    {
        $map = $definition->environments[$environment] ?? null;
        if (!is_array($map) || $map === []) {
            throw new RuntimeException("MSSQL environment not configured for {$definition->code}: {$environment}");
        }

        return $this->resolveMssqlVariantMap($definition->code, $map, $definition->driverMode);
    }

    private function resolveSybaseBaseKey(string $baseKey): array
    {
        $map = [];
        $dsnKey = $baseKey . '_dsn';
        $dblibKey = $baseKey . '_dblib';

        if ($this->registry->getFlatConfig($dsnKey) !== null) {
            $map['windows']['dsn'] = [
                'resolved_key' => $dsnKey,
                'config' => $this->registry->getFlatConfig($dsnKey),
            ];
            $map['linux']['dsn'] = [
                'resolved_key' => $dsnKey,
                'config' => $this->registry->getFlatConfig($dsnKey),
            ];
        }

        if ($this->registry->getFlatConfig($dblibKey) !== null) {
            $map['windows']['dblib'] = [
                'resolved_key' => $dblibKey,
                'config' => $this->registry->getFlatConfig($dblibKey),
            ];
            $map['linux']['dblib'] = [
                'resolved_key' => $dblibKey,
                'config' => $this->registry->getFlatConfig($dblibKey),
            ];
        }

        if ($map === []) {
            throw new RuntimeException("Sybase base connection not configured: {$baseKey}");
        }

        return $this->resolveSybaseVariantMap($baseKey, $map, 'auto');
    }

    private function resolveSybaseVariantMap(string $requestedCode, array $variantMap, string $driverMode = 'auto'): array
    {
        $driverMode = strtolower(trim($driverMode));
        $os = $this->runtimeConfig->getOsFamily();
        $drivers = PDO::getAvailableDrivers();
        $hasOdbc = in_array('odbc', $drivers, true);
        $hasDblib = in_array('dblib', $drivers, true);

        $primary = null;
        $fallback = null;

        if ($driverMode !== '' && $driverMode !== 'auto') {
            $primary = $variantMap[$os][$driverMode] ?? $variantMap['windows'][$driverMode] ?? $variantMap['linux'][$driverMode] ?? null;
        }

        if ($primary === null && $os === 'windows') {
            $primary = $hasOdbc ? ($variantMap['windows']['dsn'] ?? $variantMap['linux']['dsn'] ?? null) : null;
            $fallback = $hasDblib ? ($variantMap['windows']['dblib'] ?? $variantMap['linux']['dblib'] ?? null) : null;
            if ($primary === null) {
                $primary = $variantMap['windows']['dsn'] ?? $variantMap['linux']['dsn'] ?? $variantMap['windows']['dblib'] ?? $variantMap['linux']['dblib'] ?? null;
            }
            if ($fallback === null) {
                $fallback = $variantMap['windows']['dblib'] ?? $variantMap['linux']['dblib'] ?? null;
            }
        } elseif ($primary === null) {
            $primary = $hasDblib ? ($variantMap['linux']['dblib'] ?? $variantMap['windows']['dblib'] ?? null) : null;
            $fallback = $hasOdbc ? ($variantMap['linux']['dsn'] ?? $variantMap['windows']['dsn'] ?? null) : null;
            if ($primary === null) {
                $primary = $variantMap['linux']['dblib'] ?? $variantMap['windows']['dblib'] ?? $variantMap['linux']['dsn'] ?? $variantMap['windows']['dsn'] ?? null;
            }
            if ($fallback === null) {
                $fallback = $variantMap['linux']['dsn'] ?? $variantMap['windows']['dsn'] ?? null;
            }
        }

        if (!is_array($primary) || empty($primary['config'])) {
            throw new RuntimeException("No suitable Sybase driver variant found for {$requestedCode}");
        }

        return [
            'requested_code' => $requestedCode,
            'resolved_key' => (string)($primary['resolved_key'] ?? $requestedCode),
            'config' => $primary['config'],
            'fallback_key' => is_array($fallback) ? (string)($fallback['resolved_key'] ?? '') : null,
            'fallback_config' => is_array($fallback) ? ($fallback['config'] ?? null) : null,
        ];
    }

    private function resolveMssqlVariantMap(string $requestedCode, array $variantMap, string $driverMode = 'auto'): array
    {
        $driverMode = strtolower(trim($driverMode));
        $os = $this->runtimeConfig->getOsFamily();
        $drivers = PDO::getAvailableDrivers();
        $hasSqlsrv = in_array('sqlsrv', $drivers, true);
        $hasOdbc = in_array('odbc', $drivers, true);
        $hasDblib = in_array('dblib', $drivers, true);

        $primary = null;
        $fallback = null;

        if ($driverMode !== '' && $driverMode !== 'auto') {
            $primary = $variantMap[$os][$driverMode] ?? $variantMap['windows'][$driverMode] ?? $variantMap['linux'][$driverMode] ?? null;
        }

        if ($primary === null && $os === 'windows') {
            $primary = $hasSqlsrv ? ($variantMap['windows']['sqlsrv'] ?? $variantMap['linux']['sqlsrv'] ?? null) : null;
            $fallback = $hasOdbc ? ($variantMap['windows']['odbc'] ?? $variantMap['linux']['odbc'] ?? null) : null;
            if ($primary === null) {
                $primary = $variantMap['windows']['sqlsrv'] ?? $variantMap['windows']['odbc'] ?? $variantMap['windows']['dblib'] ?? $variantMap['linux']['odbc'] ?? $variantMap['linux']['dblib'] ?? null;
            }
            if ($fallback === null) {
                $fallback = $hasDblib ? ($variantMap['windows']['dblib'] ?? $variantMap['linux']['dblib'] ?? null) : ($variantMap['windows']['odbc'] ?? $variantMap['linux']['odbc'] ?? null);
            }
        } elseif ($primary === null) {
            $primary = $hasOdbc ? ($variantMap['linux']['odbc'] ?? $variantMap['windows']['odbc'] ?? null) : null;
            $fallback = $hasDblib ? ($variantMap['linux']['dblib'] ?? $variantMap['windows']['dblib'] ?? null) : null;
            if ($primary === null) {
                $primary = $variantMap['linux']['odbc'] ?? $variantMap['linux']['dblib'] ?? $variantMap['windows']['sqlsrv'] ?? $variantMap['windows']['odbc'] ?? $variantMap['windows']['dblib'] ?? null;
            }
            if ($fallback === null) {
                $fallback = $variantMap['linux']['dblib'] ?? $variantMap['windows']['dblib'] ?? $variantMap['windows']['sqlsrv'] ?? null;
            }
        }

        if (!is_array($primary) || empty($primary['config'])) {
            throw new RuntimeException("No suitable MSSQL driver variant found for {$requestedCode}");
        }

        return [
            'requested_code' => $requestedCode,
            'resolved_key' => (string)($primary['resolved_key'] ?? $requestedCode),
            'config' => $primary['config'],
            'fallback_key' => is_array($fallback) ? (string)($fallback['resolved_key'] ?? '') : null,
            'fallback_config' => is_array($fallback) ? ($fallback['config'] ?? null) : null,
        ];
    }
}
