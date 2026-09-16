<?php

declare(strict_types=1);

namespace App\Models;

use Core\Database\Model;

class Page extends Model
{
    protected static string $table = 'pages';

    protected static array $casts = [
        'seo' => 'json',
    ];

    /** @return array<string, array<string, mixed>> */
    public function translations(): array
    {
        $rows = static::db()->connection()->select(
            'SELECT * FROM page_translations WHERE page_id = ?',
            [$this->getKey()],
        );

        $out = [];
        foreach ($rows as $row) {
            $out[$row['locale']] = $row;
        }

        return $out;
    }

    public function translate(string $locale): ?array
    {
        return $this->translations()[$locale] ?? null;
    }
}
