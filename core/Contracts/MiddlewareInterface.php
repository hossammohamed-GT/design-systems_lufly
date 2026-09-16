<?php

declare(strict_types=1);

namespace Core\Contracts;

use Core\Http\Request;
use Core\Http\Response;

interface MiddlewareInterface
{
    /** @param callable(Request): Response $next */
    public function handle(Request $request, callable $next): Response;
}
