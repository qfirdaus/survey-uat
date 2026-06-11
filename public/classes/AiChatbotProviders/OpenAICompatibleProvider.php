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

class OpenAICompatibleProvider implements AiChatbotProviderInterface
{
    /** @var array<string,mixed> */
    protected array $config;
    protected string $providerCode;
    protected string $defaultBaseUrl;
    protected string $defaultModel;

    /**
     * @param array<string,mixed> $config
     */
    public function __construct(
        array $config,
        string $providerCode,
        string $defaultBaseUrl,
        string $defaultModel
    ) {
        $this->config = $config;
        $this->providerCode = $providerCode;
        $this->defaultBaseUrl = $defaultBaseUrl;
        $this->defaultModel = $defaultModel;
    }

    public function send(array $messages, array $options = []): array
    {
        $started = microtime(true);
        $baseUrlValue = trim((string)($this->config['base_url'] ?? ''));
        $modelValue = trim((string)($this->config['model'] ?? ''));
        $baseUrl = rtrim($baseUrlValue !== '' ? $baseUrlValue : $this->defaultBaseUrl, '/');
        $model = $modelValue !== '' ? $modelValue : $this->defaultModel;
        $apiKey = trim((string)($this->config['api_key'] ?? ''));
        $timeout = max(1, (int)($this->config['timeout_seconds'] ?? 30));
        $maxTokens = max(64, (int)($this->config['max_output_tokens'] ?? 800));

        if ($model === '') {
            throw new InvalidArgumentException($this->providerCode . ' model is not configured.');
        }

        if ($apiKey === '') {
            throw new InvalidArgumentException($this->providerCode . ' API key is not configured.');
        }

        $endpoint = $this->chatCompletionsEndpoint($baseUrl);
        $payload = [
            'model' => $model,
            'messages' => $messages,
            'stream' => false,
            'max_tokens' => $maxTokens,
            'temperature' => (float)($options['temperature'] ?? 0.3),
        ];

        $response = $this->postJson($endpoint, $payload, $timeout, $apiKey);
        $content = trim((string)($response['choices'][0]['message']['content'] ?? ''));

        if ($content === '') {
            throw new RuntimeException($this->providerCode . ' returned an empty response.');
        }

        return [
            'success' => true,
            'provider' => $this->providerCode,
            'model' => $model,
            'message' => $content,
            'latency_ms' => (int)round((microtime(true) - $started) * 1000),
            'usage' => is_array($response['usage'] ?? null) ? $response['usage'] : [],
            'error_code' => null,
            'error_message' => null,
        ];
    }

    protected function chatCompletionsEndpoint(string $baseUrl): string
    {
        if (str_ends_with($baseUrl, '/chat/completions')) {
            return $baseUrl;
        }

        return str_ends_with($baseUrl, '/v1')
            ? $baseUrl . '/chat/completions'
            : $baseUrl . '/v1/chat/completions';
    }

    /**
     * @return array<int,string>
     */
    protected function headers(string $apiKey): array
    {
        return [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey,
        ];
    }

    /**
     * @param array<string,mixed> $payload
     * @return array<string,mixed>
     */
    protected function postJson(string $url, array $payload, int $timeout, string $apiKey): array
    {
        $body = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if (!is_string($body)) {
            throw new RuntimeException('Unable to encode ' . $this->providerCode . ' request payload.');
        }

        $headers = $this->headers($apiKey);

        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            if ($ch === false) {
                throw new RuntimeException('Unable to initialize HTTP client.');
            }

            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_POSTFIELDS => $body,
                CURLOPT_CONNECTTIMEOUT => min(5, $timeout),
                CURLOPT_TIMEOUT => $timeout,
            ]);

            $raw = curl_exec($ch);
            $status = (int)curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if (!is_string($raw)) {
                throw new RuntimeException($error !== '' ? $error : $this->providerCode . ' request failed.');
            }

            return $this->decodeResponse($raw, $status);
        }

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => implode("\r\n", $headers) . "\r\n",
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
            throw new RuntimeException($this->providerCode . ' request failed.');
        }

        return $this->decodeResponse($raw, $status);
    }

    /**
     * @return array<string,mixed>
     */
    protected function decodeResponse(string $raw, int $status): array
    {
        $decoded = json_decode($raw, true);
        if (!is_array($decoded)) {
            throw new RuntimeException($this->providerCode . ' returned invalid JSON.');
        }

        if ($status >= 400) {
            $message = (string)($decoded['error']['message'] ?? $decoded['error'] ?? $this->providerCode . ' provider error.');
            throw new RuntimeException($message);
        }

        return $decoded;
    }
}
