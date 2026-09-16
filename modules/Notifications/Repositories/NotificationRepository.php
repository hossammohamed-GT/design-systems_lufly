<?php

declare(strict_types=1);

namespace Modules\Notifications\Repositories;

use App\Repositories\Repository;
use Modules\Notifications\Models\Notification;

class NotificationRepository extends Repository
{
    protected string $model = Notification::class;

    /** @return Notification[] */
    public function forUser(int|string $userId, bool $unreadOnly = false): array
    {
        $query = Notification::query()
            ->where('user_id', (int) $userId)
            ->latest();

        if ($unreadOnly) {
            $query->whereNull('read_at');
        }

        /** @var Notification[] $items */
        $items = $query->get();

        return $items;
    }
}
