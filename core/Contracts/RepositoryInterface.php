<?php

declare(strict_types=1);

namespace Core\Contracts;

use Core\Database\Paginator;

interface RepositoryInterface
{
    public function find(int|string $id): ?object;

    /** @return object[] */
    public function all(array $orderBy = ['id' => 'desc'], int $limit = 0): array;

    /** @param array<string, mixed> $data */
    public function create(array $data): object;

    /** @param array<string, mixed> $data */
    public function update(int|string $id, array $data): bool;

    public function delete(int|string $id): bool;

    /** @param array<string, mixed> $filters */
    public function paginate(array $filters = [], int $page = 1, int $perPage = 10): Paginator;
}
