<?php

declare(strict_types=1);

namespace Modules\Media\Repositories;

use App\Repositories\Repository;
use Modules\Media\Models\Media;

class MediaRepository extends Repository
{
    protected string $model = Media::class;

    protected bool $auditing = true;

    protected string $auditEntity = 'media';

    /** @return Media[] */
    public function byCollection(string $collection): array
    {
        /** @var Media[] $items */
        $items = Media::query()->where('collection', $collection)->latest()->get();

        return $items;
    }
}
