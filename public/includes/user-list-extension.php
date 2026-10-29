<?php
/**
 * IQS FRAMEWORK CORE FILE
 *
 * READ ONLY for downstream project programmers.
 * Project implementations belong under public/extensions/project/.
 *
 * IQS Framework user-list extension contract.
 *
 * Projects may register trusted callbacks in:
 *   public/extensions/project/user-list.php
 *
 * The project directory is deliberately excluded from framework sync. When no
 * project extension exists, every function in this file is a no-op.
 */
declare(strict_types=1);

function iqs_user_list_extension_config(): array
{
    static $config;
    if (is_array($config)) {
        return $config;
    }

    $config = ['tabs' => [], 'query_filters' => [], 'sync_guards' => []];
    $file = defined('IQS_USER_LIST_EXTENSION_FILE')
        ? (string)IQS_USER_LIST_EXTENSION_FILE
        : dirname(__DIR__) . '/extensions/project/user-list.php';

    if (!is_file($file)) {
        return $config;
    }

    $registered = require $file;
    if (!is_array($registered)) {
        error_log('[user-list-extension] Registration file must return an array.');
        return $config;
    }

    foreach (array_keys($config) as $section) {
        if (isset($registered[$section]) && is_array($registered[$section])) {
            $config[$section] = $registered[$section];
        }
    }
    return $config;
}

function iqs_user_list_extension_render(string $slot): void
{
    foreach (iqs_user_list_extension_config()['tabs'] as $tab) {
        if (!is_array($tab) || ($tab['slot'] ?? '') !== $slot) {
            continue;
        }
        $renderer = $tab['render'] ?? null;
        if (is_callable($renderer)) {
            $renderer($tab);
        }
    }
}

/**
 * Return parameterised predicates for a framework query.
 *
 * Each project callback receives the PDO connection and context and may return
 * one fragment (`sql`, `params`) or a list of fragments. SQL is trusted local
 * project code; values must always be supplied through `params`.
 */
function iqs_user_list_extension_query_filters(PDO $pdo, string $scope, array $context = []): array
{
    $filters = iqs_user_list_extension_config()['query_filters'][$scope] ?? [];
    if (is_callable($filters)) {
        $filters = [$filters];
    }
    if (!is_array($filters)) {
        return [];
    }

    $result = [];
    foreach ($filters as $filter) {
        if (!is_callable($filter)) {
            continue;
        }
        $fragments = $filter($pdo, $context);
        if (isset($fragments['sql'])) {
            $fragments = [$fragments];
        }
        if (!is_array($fragments)) {
            continue;
        }
        foreach ($fragments as $fragment) {
            $sql = trim((string)($fragment['sql'] ?? ''));
            $params = $fragment['params'] ?? [];
            if ($sql !== '' && is_array($params)) {
                $result[] = ['sql' => $sql, 'params' => $params];
            }
        }
    }
    return $result;
}

function iqs_user_list_extension_apply_query_filters(
    PDO $pdo,
    string $scope,
    array &$where,
    array &$params,
    array $context = []
): void {
    foreach (iqs_user_list_extension_query_filters($pdo, $scope, $context) as $fragment) {
        foreach ($fragment['params'] as $name => $value) {
            if (!is_string($name) || $name === '' || $name[0] !== ':') {
                throw new InvalidArgumentException('Extension query parameter names must start with a colon.');
            }
            if (array_key_exists($name, $params)) {
                throw new LogicException('Duplicate extension query parameter: ' . $name);
            }
            $params[$name] = $value;
        }
        $where[] = '(' . $fragment['sql'] . ')';
    }
}

function iqs_user_list_extension_sync_allowed(PDO $pdo, string $scope, array $record, array $context = []): bool
{
    $guards = iqs_user_list_extension_config()['sync_guards'][$scope] ?? [];
    if (is_callable($guards)) {
        $guards = [$guards];
    }
    if (!is_array($guards)) {
        return true;
    }

    foreach ($guards as $guard) {
        if (is_callable($guard) && $guard($pdo, $record, $context) === false) {
            return false;
        }
    }
    return true;
}
