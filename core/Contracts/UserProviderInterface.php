<?php

declare(strict_types=1);

namespace Core\Contracts;

/**
 * Contract implemented by the Users module so core Auth stays decoupled.
 */
interface UserProviderInterface
{
    /** @return object|null entity exposing id, email, password, name, status */
    public function findByEmail(string $email): ?object;

    public function findById(int|string $id): ?object;

    /** @return string[] permission keys granted to the user */
    public function permissionsFor(int|string $userId): array;
}
