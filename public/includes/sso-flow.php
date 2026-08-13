<?php
/** Pure OneID SSO response and identity helpers; safe for offline regression tests. */
declare(strict_types=1);

function SSO_SANITIZE_IDENTIFIER($value): string
{
    return trim((string)$value);
}

function SSO_VALIDATE_STAFID($value): bool
{
    $value = SSO_SANITIZE_IDENTIFIER($value);
    return $value !== '' && preg_match('/^\d{4}-\d{2}$/', $value) === 1;
}

function SSO_VALIDATE_MATRIK($value): bool
{
    $value = SSO_SANITIZE_IDENTIFIER($value);
    return $value !== '' && preg_match('/^[A-Za-z0-9]{1,12}$/', $value) === 1;
}

function SSO_BUILD_AUTH_HANDOFF($packet): array
{
    $packet = is_array($packet) ? $packet : [];
    $data3 = SSO_SANITIZE_IDENTIFIER($packet['data3'] ?? '');
    $data4 = SSO_SANITIZE_IDENTIFIER($packet['data4'] ?? '');
    $validStafId = SSO_VALIDATE_STAFID($data3) ? $data3 : '';
    $validMatrik = SSO_VALIDATE_MATRIK($data4) ? $data4 : '';
    $identityConflict = $validStafId !== '' && $validMatrik !== '';
    $resolvedLoginId = '';
    $resolvedSource = '';

    if (!$identityConflict && $validStafId !== '') {
        $resolvedLoginId = $validStafId;
        $resolvedSource = 'data3';
    } elseif (!$identityConflict && $validMatrik !== '') {
        $resolvedLoginId = $validMatrik;
        $resolvedSource = 'data4';
    }

    return [
        'valid_token' => true,
        'resolved_login_id' => $resolvedLoginId,
        'resolved_source' => $resolvedSource,
        'data3_valid' => $validStafId !== '',
        'data4_valid' => $validMatrik !== '',
        'identity_valid' => $resolvedLoginId !== '',
        'identity_conflict' => $identityConflict,
    ];
}

function SSO_CLASSIFY_API_RESPONSE($response): array
{
    if (!is_array($response) || $response === []) return ['status' => 'invalid_response'];
    $flag = (string)($response['respond_flag'] ?? '');
    if ($flag === '2') {
        $token = trim((string)($response['respond_new_token'] ?? ''));
        $packet = $response['respond_user_packet'] ?? null;
        return $token !== '' && is_array($packet)
            ? ['status' => 'valid', 'token' => $token, 'packet' => $packet, 'reissued' => true]
            : ['status' => 'invalid_response'];
    }
    if ($flag !== '1') return ['status' => 'invalid_response'];
    if ((string)($response['respond'] ?? '') === '1' && is_array($response['respond_user_packet'] ?? null)) {
        return ['status' => 'valid', 'packet' => $response['respond_user_packet'], 'reissued' => false];
    }
    if ((string)($response['respond'] ?? '') === '0') {
        $reasonText = strtolower(trim((string)($response['reason'] ?? $response['message'] ?? $response['respond_message'] ?? '')));
        $isSiteError = str_contains($reasonText, 'site') && (str_contains($reasonText, 'invalid') || str_contains($reasonText, 'not found'));
        return ['status' => $isSiteError ? 'invalid_site' : 'invalid_token'];
    }
    return ['status' => 'invalid_response'];
}
