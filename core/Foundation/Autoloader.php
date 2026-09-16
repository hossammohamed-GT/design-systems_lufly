<?php

declare(strict_types=1);

namespace Core\Foundation;

/**
 * PSR-4 autoloader.
 */
final class Autoloader
{
    /** @var array<string, string> */
    private static array $prefixes = [];

    /** @param array<string, string> $prefixes namespace prefix => base directory */
    public static function register(array $prefixes): void
    {
        foreach ($prefixes as $prefix => $dir) {
            self::$prefixes[$prefix] = rtrim($dir, '/\\') . DIRECTORY_SEPARATOR;
        }
        spl_autoload_register([self::class, 'load']);
    }

    public static function load(string $class): bool
    {
        foreach (self::$prefixes as $prefix => $baseDir) {
            if (str_starts_with($class, $prefix)) {
                $relative = substr($class, strlen($prefix));
                $file = $baseDir . str_replace('\\', DIRECTORY_SEPARATOR, $relative) . '.php';
                if (is_file($file)) {
                    require $file;
                    return true;
                }
            }
        }
        return false;
    }
}
