<?php

declare(strict_types=1);

namespace Core\Config;

/**
 * Minimal .env loader. Values are exposed through env() and $_ENV.
 */
final class Env
{
    public static function load(string $path): void
    {
        if (!is_file($path)) {
            return;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
                continue;
            }

            [$key, $value] = explode('=', $line, 2);
            $key = trim($key);
            $value = self::parseValue(trim($value));

            if (getenv($key) !== false && !isset($_ENV[$key])) {
                continue;
            }

            $_ENV[$key] = $value;
            putenv($key . '=' . (is_scalar($value) ? (string) $value : ''));
        }
    }

    private static function parseValue(string $value): string|bool|null
    {
        if ($value !== '' && ($value[0] === '"' || $value[0] === "'")) {
            $quote = $value[0];
            if (str_ends_with($value, $quote) && strlen($value) >= 2) {
                return substr($value, 1, -1);
            }
        }

        return match (strtolower($value)) {
            'true' => true,
            'false' => false,
            'null', '' => null,
            default => $value,
        };
    }
}
