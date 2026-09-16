<?php

declare(strict_types=1);

namespace Core\Contracts;

/**
 * PSR-11 inspired service container contract.
 */
interface ContainerInterface
{
    public function get(string $id): mixed;

    public function has(string $id): bool;

    public function bind(string $abstract, callable|string|null $concrete = null, bool $shared = false): void;

    public function singleton(string $abstract, callable|string|null $concrete = null): void;

    public function instance(string $abstract, mixed $instance): void;
}
