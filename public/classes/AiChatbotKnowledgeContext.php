<?php
/**
 * IQS FRAMEWORK CORE FILE
 *
 * READ ONLY for downstream project programmers.
 * Do not modify this file directly in template or cloned projects.
 * Custom changes must be implemented in project-specific files
 * or approved extension points.
 */
declare(strict_types=1);

final class AiChatbotKnowledgeContext
{
    private const TABLE_NAME = 'tbl_ai_chat_knowledge';
    private const MAX_ITEMS = 5;
    private const MAX_TERMS = 6;
    private const MAX_ANSWER_CHARS = 900;

    public function __construct(private readonly PDO $pdo)
    {
    }

    /**
     * @param array<string,mixed> $profile
     * @param array<string,mixed> $actor
     * @return array<string,mixed>
     */
    public function build(string $message, array $profile, array $actor = []): array
    {
        if (!$this->tableExists()) {
            return [];
        }

        $terms = $this->extractTerms($message);
        if ($terms === []) {
            return [];
        }

        $lang = $this->safeLang((string)($actor['lang'] ?? $_SESSION['lang'] ?? 'ms'));
        $groupId = (int)($actor['active_group_id'] ?? $_SESSION['group_active_id'] ?? ($profile['f_groupID'] ?? 0));
        $groupCode = strtoupper(trim((string)($actor['active_group_code'] ?? $profile['f_groupKod'] ?? '')));
        $isSuperAdmin = (bool)($actor['is_super_admin'] ?? false);

        try {
            $items = $this->fetchItems($terms, $lang, $groupId, $groupCode, $isSuperAdmin);
            if ($items === []) {
                return [];
            }

            return [
                'source' => 'curated_knowledge_base',
                'visibility_filtered' => true,
                'search_terms' => $terms,
                'filters' => [
                    'language' => $lang,
                    'group_id' => $groupId,
                    'group_code' => $groupCode,
                    'super_admin' => $isSuperAdmin,
                ],
                'totals' => ['items_in_prompt' => count($items)],
                'items' => $items,
            ];
        } catch (Throwable $e) {
            error_log('[ai-chatbot-knowledge-context] ' . $e->getMessage());
            return [];
        }
    }

    /**
     * @param array<int,string> $terms
     * @return array<int,array<string,string>>
     */
    private function fetchItems(array $terms, string $lang, int $groupId, string $groupCode, bool $isSuperAdmin): array
    {
        $params = [
            ':lang' => $lang,
            ':group_id' => (string)$groupId,
            ':group_code' => $groupCode,
            ':is_super_admin' => $isSuperAdmin ? 1 : 0,
            ':limit' => self::MAX_ITEMS,
        ];

        $searchParts = [];
        foreach ($terms as $index => $term) {
            $key = ':term' . $index;
            $params[$key] = '%' . $term . '%';
            $searchParts[] = "(f_title LIKE {$key} OR COALESCE(f_question, '') LIKE {$key} OR COALESCE(f_tags, '') LIKE {$key} OR f_answer LIKE {$key})";
        }

        $sql = "
            SELECT
                f_title,
                f_question,
                f_answer,
                f_language,
                f_visibility,
                f_tags
            FROM " . self::TABLE_NAME . "
            WHERE f_status = 'active'
              AND (f_language = :lang OR f_language = 'all' OR f_language = '')
              AND (
                f_visibility = 'all_authenticated'
                OR (:is_super_admin = 1 AND f_visibility = 'super_admin_only')
                OR (
                  f_visibility = 'selected_groups'
                  AND (
                    FIND_IN_SET(:group_id, REPLACE(COALESCE(f_allowedGroups, ''), ' ', '')) > 0
                    OR FIND_IN_SET(:group_code, UPPER(REPLACE(COALESCE(f_allowedGroups, ''), ' ', ''))) > 0
                  )
                )
              )
              AND (" . implode(' OR ', $searchParts) . ")
            ORDER BY f_priority ASC, f_updatedDt DESC, f_createdDt DESC
            LIMIT :limit";

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, $key === ':limit' || $key === ':is_super_admin' ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $stmt->execute();

        $items = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) ?: [] as $row) {
            $title = $this->safeText((string)($row['f_title'] ?? ''), 180);
            $answer = $this->safeText(strip_tags((string)($row['f_answer'] ?? '')), self::MAX_ANSWER_CHARS);
            if ($title === '' || $answer === '') {
                continue;
            }

            $items[] = [
                'title' => $title,
                'question' => $this->safeText((string)($row['f_question'] ?? ''), 240),
                'answer' => $answer,
                'language' => $this->safeText((string)($row['f_language'] ?? ''), 10),
                'visibility' => $this->safeText((string)($row['f_visibility'] ?? ''), 40),
                'tags' => $this->safeText((string)($row['f_tags'] ?? ''), 180),
            ];
        }

        return $items;
    }

    /**
     * @return array<int,string>
     */
    private function extractTerms(string $message): array
    {
        $message = mb_strtolower(strip_tags($message), 'UTF-8');
        $message = preg_replace('/[^\p{L}\p{N}\s]+/u', ' ', (string)$message);
        $parts = preg_split('/\s+/u', trim((string)$message)) ?: [];
        $stopwords = [
            'apa' => true, 'itu' => true, 'ini' => true, 'dan' => true, 'atau' => true,
            'yang' => true, 'untuk' => true, 'boleh' => true, 'macam' => true, 'mana' => true,
            'how' => true, 'what' => true, 'where' => true, 'the' => true, 'and' => true,
            'for' => true, 'can' => true, 'you' => true, 'please' => true,
        ];

        $terms = [];
        foreach ($parts as $part) {
            $part = trim($part);
            if (mb_strlen($part, 'UTF-8') < 3 || isset($stopwords[$part])) {
                continue;
            }
            $terms[] = $part;
            if (count($terms) >= self::MAX_TERMS) {
                break;
            }
        }

        return array_values(array_unique($terms));
    }

    private function tableExists(): bool
    {
        try {
            $stmt = $this->pdo->prepare('SHOW TABLES LIKE :table_name');
            $stmt->execute([':table_name' => self::TABLE_NAME]);
            return (bool)$stmt->fetchColumn();
        } catch (Throwable $e) {
            return false;
        }
    }

    private function safeLang(string $lang): string
    {
        return in_array($lang, ['ms', 'en', 'zh', 'ta'], true) ? $lang : 'ms';
    }

    private function safeText(string $value, int $maxLength): string
    {
        $value = preg_replace('/[\x00-\x1F\x7F]+/u', ' ', $value);
        $value = trim((string)$value);

        return mb_substr($value, 0, max(1, $maxLength), 'UTF-8');
    }
}
