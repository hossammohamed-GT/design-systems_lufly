<?php

declare(strict_types=1);

namespace App\Services;

class SEOService
{
    /** @var array<string, mixed> */
    private array $meta = [];

    /** @var array<int, array{type: string, data: array<string, mixed>}> */
    private array $structured = [];

    public function __construct()
    {
        $this->meta = (array) config('seo.defaults', []);
    }

    public function setTitle(string $title): void
    {
        $this->meta['title'] = $title;
    }

    public function setDescription(string $description): void
    {
        $this->meta['description'] = $description;
    }

    /** @param string[] $keywords */
    public function setKeywords(array $keywords): void
    {
        $this->meta['keywords'] = $keywords;
    }

    public function setCanonical(string $url): void
    {
        $this->meta['canonical'] = $url;
    }

    public function setImage(string $url): void
    {
        $this->meta['image'] = $url;
    }

    /** @param array<string, mixed> $entity entity data merged into structured data */
    public function setFromEntity(array $entity): void
    {
        if (isset($entity['seo']) && is_array($entity['seo'])) {
            foreach ($entity['seo'] as $key => $value) {
                if ($value !== null && $value !== '') {
                    $this->meta[$key] = $value;
                }
            }
        }
        if (isset($entity['title'])) {
            $this->setTitle((string) $entity['title']);
        }
        if (isset($entity['description'])) {
            $this->setDescription((string) $entity['description']);
        }
    }

    /** @param array<string, mixed> $data */
    public function addStructuredData(string $type, array $data): void
    {
        $this->structured[] = ['type' => $type, 'data' => $data];
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        $meta = $this->meta;
        $meta['title'] = ($meta['title'] ?? '') . (string) config('seo.title_suffix', '');

        return $meta;
    }

    /** @return array<int, array{type: string, data: array<string, mixed>}> */
    public function structuredData(): array
    {
        return $this->structured;
    }

    public function reset(): void
    {
        $this->meta = (array) config('seo.defaults', []);
        $this->structured = [];
    }
}
