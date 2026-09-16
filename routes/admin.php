<?php

declare(strict_types=1);

use App\Http\Controllers\DashboardController;
use Core\Http\Router;

return function (Router $router): void {
    $router->group([
        'prefix' => 'admin',
        'middleware' => ['web', 'auth'],
        'name' => 'admin.',
    ], function (Router $router): void {
        $router->get('/', [DashboardController::class, 'index'])->name('dashboard');
    });
};
