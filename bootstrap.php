<?php

declare(strict_types=1);

use Core\Config\Config;
use Core\Config\Env;
use Core\Exceptions\Handler;
use Core\Foundation\Application;
use Core\Foundation\Autoloader;

require __DIR__ . '/core/Foundation/Autoloader.php';

Autoloader::register([
    'Core\\'      => __DIR__ . '/core',
    'App\\'       => __DIR__ . '/app',
    'Modules\\'   => __DIR__ . '/modules',
    'Database\\'  => __DIR__ . '/database',
]);

require __DIR__ . '/core/Foundation/helpers.php';

Env::load(__DIR__ . '/.env');

$app = new Application(__DIR__);
$GLOBALS['__app'] = $app;

Config::setPath($app->basePath('config'));

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

Handler::register($app);

$app->registerProviders();
$app->bootProviders();

return $app;
