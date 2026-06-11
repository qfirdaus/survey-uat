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

require_once __DIR__ . '/AiChatbotProviderInterface.php';
require_once __DIR__ . '/AiChatbotProviders/OllamaProvider.php';
require_once __DIR__ . '/AiChatbotProviders/GroqProvider.php';
require_once __DIR__ . '/AiChatbotProviders/OpenRouterProvider.php';

final class AiChatbotProviderRegistry
{
    /**
     * @param array<string,mixed> $config
     */
    public static function resolve(array $config): AiChatbotProviderInterface
    {
        $provider = strtolower(trim((string)($config['provider'] ?? 'ollama')));

        return match ($provider) {
            'ollama' => new OllamaProvider($config),
            'groq' => new GroqProvider($config),
            'openrouter' => new OpenRouterProvider($config),
            default => throw new InvalidArgumentException('Unsupported AI chatbot provider.'),
        };
    }
}
