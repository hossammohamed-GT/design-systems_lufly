<?php

declare(strict_types=1);

namespace Core\Foundation;

use Core\Foundation\Application;

/**
 * Discovers modules/ entries and loads their Routes/routes.php files.
 */
final class ModuleManager
{
    /** @var string[] */
    private array $enabled = [];

    public function __construct(private readonly Application $app)
    {
        $this->enabled = (array) config('modules.enabled', []);
    }

    /** @return string[] */
    public function enabled(): array
    {
        return $this->enabled;
    }

    public function isEnabled(string $module): bool
    {
        return in_array($module, $this->enabled, true);
    }

    public function path(string $module, string $path = ''): string
    {
        return $this->app->modulePath($module . ($path !== '' ? '/' . $path : ''));
    }

    public function loadRoutes(\Core\Http\Router $router): void
    {
        foreach ($this->enabled as $module) {
            $file = $this->path($module, 'Routes/routes.php');
            if (is_file($file)) {
                $callback = require $file;
                if (is_callable($callback)) {
                    $callback($router);
                }
            }
        }
    }
}
