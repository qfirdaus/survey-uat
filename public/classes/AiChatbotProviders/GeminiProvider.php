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

require_once __DIR__ . '/../AiChatbotProviderInterface.php';

final class GeminiProvider implements AiChatbotProviderInterface
{
    /** @var array<string,mixed> */
    private array $config;

    /**
     * @param array<string,mixed> $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function send(array $messages, array $options = []): array
    {
        $started = microtime(true);
        $baseUrlValue = trim((string)($this->config['base_url'] ?? ''));
        $modelValue = trim((string)($this->config['model'] ?? ''));
        $baseUrl = rtrim($baseUrlValue !== '' ? $baseUrlValue : 'https://generativelanguage.googleapis.com', '/');
        $model = $modelValue !== '' ? $modelValue : 'gemini-1.5-flash';
        $apiKey = trim((string)($this->config['api_key'] ?? ''));
        $timeout = max(1, (int)($this->config['timeout_seconds'] ?? 30));
        $maxTokens = max(64, (int)($this->config['max_output_tokens'] ?? 800));

        if ($model === '') {
            throw new InvalidArgumentException('Gemini model is not configured.');
        }

        if ($apiKey === '') {
            throw new InvalidArgumentException('Gemini API key is not configured.');
        }

        $systemText = '';
        $contents = [];
        foreach ($messages as $message) {
            $role = (string)($message['role'] ?? '');
            $content = (string)($message['content'] ?? '');
            if ($content === '') {
                continue;
            }
            if ($role === 'system') {
                $systemText = trim($systemText . "\n" . $content);
                continue;
            }
            $contents[] = [
                'role' => $role === 'assistant' ? 'model' : 'user',
                'parts' => [
                    ['text' => $content],
                ],
            ];
        }

        $payload = [
            'contents' => $contents,
            'generationConfig' => [
                'maxOutputTokens' => $maxTokens,
                'temperature' => (float)($options['temperature'] ?? 0.3),
            ],
        ];
        if ($systemText !== '') {
            $payload['systemInstruction'] = [
                'parts' => [
                    ['text' => $systemText],
                ],
            ];
        }

        $endpoint = $this->generateContentEndpoint($baseUrl, $model, $apiKey);
        $response = $this->postJson($endpoint, $payload, $timeout);
        $content = $this->extractText($response);
        if ($content === '') {
            throw new RuntimeException('Gemini returned an empty response.');
        }

        return [
            'success' => true,
            'provider' => 'gemini',
            'model' => $model,
            'message' => $content,
            'latency_ms' => (int)round((microtime(true) - $started) * 1000),
            'usage' => is_array($response['usageMetadata'] ?? null) ? $response['usageMetadata'] : [],
            'error_code' => null,
            'error_message' => null,
        ];
    }

    private function generateContentEndpoint(string $baseUrl, string $model, string $apiKey): string
    {
        $encodedModel = rawurlencode($model);
        if (str_contains($baseUrl, ':generateContent')) {
            $separator = str_contains($baseUrl, '?') ? '&' : '?';
            return $baseUrl . $separator . 'key=' . rawurlencode($apiKey);
        }

        return $baseUrl . '/v1beta/models/' . $encodedModel . ':generateContent?key=' . rawurlencode($apiKey);
    }

    /**
     * @param array<string,mixed> $payload
     * @return array<string,mixed>
     */
    private function postJson(string $url, array $payload, int $timeout): array
    {
        $body = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if (!is_string($body)) {
            throw new RuntimeException('Unable to encode Gemini request payload.');
        }

        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            if ($ch === false) {
                throw new RuntimeException('Unable to initialize HTTP client.');
            }

            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                CURLOPT_POSTFIELDS => $body,
                CURLOPT_CONNECTTIMEOUT => min(5, $timeout),
                CURLOPT_TIMEOUT => $timeout,
            ]);

            $raw = curl_exec($ch);
            $status = (int)curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if (!is_string($raw)) {
                throw new RuntimeException($error !== '' ? $error : 'Gemini request failed.');
            }

            return $this->decodeResponse($raw, $status);
        }

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\n",
                'content' => $body,
                'timeout' => $timeout,
                'ignore_errors' => true,
            ],
        ]);

        $raw = @file_get_contents($url, false, $context);
        $status = 0;
        if (isset($http_response_header) && is_array($http_response_header)) {
            foreach ($http_response_header as $header) {
                if (preg_match('/^HTTP\/\S+\s+(\d{3})/', (string)$header, $matches)) {
                    $status = (int)$matches[1];
                    break;
                }
            }
        }

        if (!is_string($raw)) {
            throw new RuntimeException('Gemini request failed.');
        }

        return $this->decodeResponse($raw, $status);
    }

    /**
     * @return array<string,mixed>
     */
    private function decodeResponse(string $raw, int $status): array
    {
        $decoded = json_decode($raw, true);
        if (!is_array($decoded)) {
            throw new RuntimeException('Gemini returned invalid JSON.');
        }

        if ($status >= 400) {
            $message = (string)($decoded['error']['message'] ?? $decoded['error'] ?? 'Gemini provider error.');
            throw new RuntimeException($message);
        }

        return $decoded;
    }

    /**
     * @param array<string,mixed> $response
     */
    private function extractText(array $response): string
    {
        $parts = [];
        foreach ((array)($response['candidates'] ?? []) as $candidate) {
            if (!is_array($candidate)) {
                continue;
            }
            foreach ((array)($candidate['content']['parts'] ?? []) as $part) {
                if (is_array($part)) {
                    $text = trim((string)($part['text'] ?? ''));
                    if ($text !== '') {
                        $parts[] = $text;
                    }
                }
            }
        }

        return trim(implode("\n", $parts));
    }
}
