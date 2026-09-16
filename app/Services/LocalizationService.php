<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Contract for language management + dynamic entity translations.
 * Implementation lives in the Languages module (DIP).
 */
abstract class LocalizationService
{
    /** @return array<int, object> */
    abstract public function languages(): array;

    /** @return array<int, object> */
    abstract public function activeLanguages(): array;

    /** @param array<string, mixed> $data */
    abstract public function storeLanguage(array $data): object;

    /** @param array<string, mixed> $data */
    abstract public function updateLanguage(int $id, array $data): bool;

    abstract public function toggleLanguage(int $id): bool;

    /** @return array<string, array<string, mixed>> locale => translation row */
    abstract public function getTranslations(string $entity, int|string $entityId): array;

    /** @param array<string, mixed> $fields */
    abstract public function upsertTranslation(string $entity, int|string $entityId, string $locale, array $fields): void;

    /** @param array<string, array<string, mixed>> $byLocale locale => fields */
    abstract public function syncTranslations(string $entity, int|string $entityId, array $byLocale): void;
}
