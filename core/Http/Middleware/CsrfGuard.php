<?php

declare(strict_types=1);

namespace Core\Http\Middleware;

use Core\Contracts\MiddlewareInterface;
use Core\Exceptions\AppException;
use Core\Http\Request;
use Core\Http\Response;
use Core\Http\Session;

final class CsrfGuard implements MiddlewareInterface
{
    private const UNSAFE_METHODS = ['POST', 'PUT', 'PATCH', 'DELETE'];

    public function __construct(private readonly Session $session)
    {
    }

    public function handle(Request $request, callable $next): Response
    {
        if (in_array($request->method(), self::UNSAFE_METHODS, true)) {
            $token = $request->input('_token') ?? $request->header('HTTP_X_CSRF_TOKEN');
            $expected = $this->session->csrfToken();

            if (!is_string($token) || !hash_equals($expected, $token)) {
                throw (new AppException('CSRF token mismatch.', 419, 'csrf_token_invalid'))
                    ->withExtra(['path' => $request->path()]);
            }
        }

        return $next($request);
    }
}
