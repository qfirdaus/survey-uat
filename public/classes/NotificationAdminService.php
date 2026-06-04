<?php
/**
 * IQS FRAMEWORK CORE FILE
 *
 * READ ONLY for downstream project programmers.
 * Do not modify this file directly in template or cloned projects.
 * Custom changes must be implemented in project-specific files
 * or approved extension points.
 */declare(strict_types=1);

require_once __DIR__ . '/NotificationPublisher.php';

final class NotificationAdminService
{
    public function __construct(private PDO $pdo) {}

    /**
     * @return array<int,array<string,mixed>>
     */
    public function getGroups(): array
    {
        $stmt = $this->pdo->query("
            SELECT f_groupID, f_groupKod, f_groupName, f_categoryUser
            FROM tbl_m_group
            ORDER BY f_groupName ASC, f_groupKod ASC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * @return array<int,array<string,mixed>>
     */
    public function getTemplates(): array
    {
        $stmt = $this->pdo->query("
            SELECT
              f_templateID,
              f_templateCode,
              f_eventCode,
              f_moduleCode,
              f_type,
              f_category,
              f_severity,
              f_priority,
              f_title_ms,
              f_title_en,
              f_body_ms,
              f_body_en,
              f_actionLabel_ms,
              f_actionLabel_en,
              f_icon,
              f_requiresAction
            FROM tbl_notification_template
            WHERE f_status = 1
            ORDER BY f_templateCode ASC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * @return array<int,array<string,mixed>>
     */
    public function getRecentNotifications(int $limit = 25): array
    {
        $limit = max(1, min(100, $limit));
        $stmt = $this->pdo->prepare("
            SELECT
              n.f_notificationID,
              n.f_eventCode,
              n.f_moduleCode,
              n.f_type,
              n.f_category,
              n.f_severity,
              n.f_priority,
              n.f_title_ms,
              n.f_title_en,
              n.f_requiresAction,
              n.f_dueAt,
              n.f_dedupeKey,
              n.f_isBroadcast,
              n.f_status,
              n.f_insertBy,
              n.f_insertdt,
              COUNT(a.f_audienceID) AS audience_count,
              GROUP_CONCAT(
                CONCAT(a.f_targetType, ':', COALESCE(a.f_targetValue, ''))
                ORDER BY a.f_audienceID ASC
                SEPARATOR '|'
              ) AS audience_summary_raw
            FROM tbl_notification n
            LEFT JOIN tbl_notification_audience a
              ON a.f_notificationID = n.f_notificationID
            GROUP BY
              n.f_notificationID,
              n.f_eventCode,
              n.f_moduleCode,
              n.f_type,
              n.f_category,
              n.f_severity,
              n.f_priority,
              n.f_title_ms,
              n.f_title_en,
              n.f_requiresAction,
              n.f_dueAt,
              n.f_dedupeKey,
              n.f_isBroadcast,
              n.f_status,
              n.f_insertBy,
              n.f_insertdt
            ORDER BY n.f_insertdt DESC, n.f_notificationID DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        foreach ($rows as &$row) {
            $row['audience_summary'] = $this->formatAudienceSummary((string)($row['audience_summary_raw'] ?? ''), (int)($row['audience_count'] ?? 0));
        }
        unset($row);

        return $rows;
    }

    /**
     * @return array<string,int>
     */
    public function getSummary(): array
    {
        $row = $this->pdo->query("
            SELECT
              COUNT(*) AS total,
              SUM(CASE WHEN f_status = 1 THEN 1 ELSE 0 END) AS active,
              SUM(CASE WHEN f_requiresAction = 1 THEN 1 ELSE 0 END) AS action_required,
              SUM(CASE WHEN f_isBroadcast = 1 THEN 1 ELSE 0 END) AS broadcast
            FROM tbl_notification
        ")->fetch(PDO::FETCH_ASSOC) ?: [];

        return [
            'total' => (int)($row['total'] ?? 0),
            'active' => (int)($row['active'] ?? 0),
            'action_required' => (int)($row['action_required'] ?? 0),
            'broadcast' => (int)($row['broadcast'] ?? 0),
        ];
    }

    /**
     * @param array<string,mixed> $input
     * @return array{notification_id:int,message:string}
     */
    public function publishFromAdminInput(array $input, string $createdBy): array
    {
        $payload = $this->buildPayload($input, $createdBy);
        $options = [
            'dedupe' => (string)($input['dedupe_behavior'] ?? 'update'),
        ];

        if (!empty($input['resolve_to_login_ids'])) {
            $options['audience_context'] = ['resolve_to_login_ids' => true];
        }

        $publisher = new NotificationPublisher($this->pdo, new NotificationAudienceResolver($this->pdo));
        $notificationId = $publisher->publish($payload, $options);

        return [
            'notification_id' => $notificationId,
            'message' => 'Notification published.',
        ];
    }

    /**
     * @param array<string,mixed> $input
     * @return array<string,mixed>
     */
    private function buildPayload(array $input, string $createdBy): array
    {
        $titleMs = trim((string)($input['title_ms'] ?? ''));
        if ($titleMs === '') {
            throw new InvalidArgumentException('Title is required.');
        }

        $eventCode = trim((string)($input['event_code'] ?? ''));
        if ($eventCode === '') {
            $eventCode = 'admin.notification.' . date('YmdHis');
        }

        $audience = $this->buildAudience($input);
        if ($audience === []) {
            throw new InvalidArgumentException('Audience is required.');
        }

        return [
            'event_code' => $eventCode,
            'template_code' => trim((string)($input['template_code'] ?? '')) ?: null,
            'module_code' => trim((string)($input['module_code'] ?? 'CORE')) ?: 'CORE',
            'type' => trim((string)($input['type'] ?? 'announcement')) ?: 'announcement',
            'category' => trim((string)($input['category'] ?? 'system')) ?: 'system',
            'severity' => trim((string)($input['severity'] ?? 'info')) ?: 'info',
            'priority' => trim((string)($input['priority'] ?? 'normal')) ?: 'normal',
            'title_ms' => $titleMs,
            'title_en' => trim((string)($input['title_en'] ?? '')),
            'body_ms' => trim((string)($input['body_ms'] ?? '')),
            'body_en' => trim((string)($input['body_en'] ?? '')),
            'action_url' => trim((string)($input['action_url'] ?? '')),
            'action_label_ms' => trim((string)($input['action_label_ms'] ?? '')),
            'action_label_en' => trim((string)($input['action_label_en'] ?? '')),
            'icon' => trim((string)($input['icon'] ?? 'ri-notification-3-line')) ?: 'ri-notification-3-line',
            'source_type' => trim((string)($input['source_type'] ?? 'admin_notification')) ?: 'admin_notification',
            'source_id' => trim((string)($input['source_id'] ?? '')),
            'requires_action' => !empty($input['requires_action']) ? 1 : 0,
            'due_at' => trim((string)($input['due_at'] ?? '')),
            'dedupe_key' => trim((string)($input['dedupe_key'] ?? '')),
            'is_broadcast' => (($input['audience_type'] ?? '') === 'ALL') ? 1 : 0,
            'starts_at' => trim((string)($input['starts_at'] ?? '')),
            'expires_at' => trim((string)($input['expires_at'] ?? '')),
            'created_by_type' => 'admin',
            'created_by_login_id' => $createdBy,
            'insert_by' => $createdBy,
            'audience' => $audience,
        ];
    }

    /**
     * @param array<string,mixed> $input
     * @return array<string,mixed>
     */
    private function buildAudience(array $input): array
    {
        $type = strtoupper(trim((string)($input['audience_type'] ?? 'ALL')));
        $rawValue = (string)($input['audience_value'] ?? '');

        return match ($type) {
            'ALL' => ['all' => true],
            'LOGIN_ID' => ['login_ids' => $this->splitValues($rawValue)],
            'RESOLVED_LOGIN_ID' => ['resolved_login_ids' => $this->splitValues($rawValue)],
            'GROUP_ID' => ['group_ids' => $this->splitValues($rawValue)],
            'CATEGORY_USER' => ['category_users' => array_map('strtoupper', $this->splitValues($rawValue))],
            'ROLE_ID' => ['role_ids' => $this->splitValues($rawValue)],
            'DEPARTMENT_ID' => ['department_ids' => $this->splitValues($rawValue)],
            'PERMISSION' => ['permission_codes' => $this->splitValues($rawValue)],
            default => [],
        };
    }

    /**
     * @return array<int,string>
     */
    private function splitValues(string $value): array
    {
        $parts = preg_split('/[\r\n,;]+/', $value) ?: [];
        $values = [];
        foreach ($parts as $part) {
            $part = trim($part);
            if ($part !== '') {
                $values[] = $part;
            }
        }
        return array_values(array_unique($values));
    }

    private function formatAudienceSummary(string $raw, int $count): string
    {
        $raw = trim($raw);
        if ($raw === '') {
            return 'No audience';
        }

        $items = array_values(array_filter(explode('|', $raw), static fn($item) => trim((string)$item) !== ''));
        if ($items === []) {
            return 'No audience';
        }

        $labels = [];
        foreach ($items as $item) {
            [$type, $value] = array_pad(explode(':', $item, 2), 2, '');
            $type = strtoupper(trim($type));
            $value = trim($value);

            $labels[] = match ($type) {
                'ALL' => 'All users',
                'LOGIN_ID' => 'Login ID: ' . $value,
                'RESOLVED_LOGIN_ID' => 'Resolved user: ' . $value,
                'GROUP_ID' => 'Group ID: ' . $value,
                'CATEGORY_USER' => 'Category: ' . $value,
                'ROLE_ID' => 'Role ID: ' . $value,
                'DEPARTMENT_ID' => 'Department ID: ' . $value,
                'PERMISSION' => 'Permission: ' . $value,
                default => $type . ($value !== '' ? ': ' . $value : ''),
            };
        }

        $labels = array_values(array_unique($labels));
        $visible = array_slice($labels, 0, 2);
        $summary = implode(', ', $visible);
        $remaining = count($labels) - count($visible);

        if ($remaining > 0) {
            $summary .= ' +' . $remaining . ' more';
        }

        if ($count > count($labels)) {
            $summary .= ' (' . $count . ' rules)';
        }

        return $summary;
    }
}
