<?php

declare(strict_types=1);

namespace App\Services;

use Core\Database\DatabaseManager;
use Core\Logging\Log;

class NotificationService
{
    public function __construct(private readonly DatabaseManager $db)
    {
    }

    /** @param array<string, mixed> $data */
    public function notify(int|string $userId, string $title, string $body, string $type = 'info', array $data = []): int|string
    {
        $id = $this->db->connection()->insert('notifications', [
            'user_id' => (int) $userId,
            'type' => $type,
            'title' => $title,
            'body' => $body,
            'data' => json_encode($data, JSON_UNESCAPED_UNICODE),
            'read_at' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        Log::info('notification.sent', ['user_id' => $userId, 'type' => $type, 'title' => $title]);

        return $id;
    }

    /** @return array<int, array<string, mixed>> */
    public function unreadFor(int|string $userId): array
    {
        return $this->db->connection()->select(
            'SELECT * FROM notifications WHERE user_id = ? AND read_at IS NULL ORDER BY id DESC',
            [(int) $userId],
        );
    }

    public function markRead(int|string $notificationId): void
    {
        $this->db->connection()->table('notifications')
            ->where('id', (int) $notificationId)
            ->update(['read_at' => date('Y-m-d H:i:s')]);
    }

    public function markAllRead(int|string $userId): void
    {
        $this->db->connection()->table('notifications')
            ->where('user_id', (int) $userId)
            ->whereNull('read_at')
            ->update(['read_at' => date('Y-m-d H:i:s')]);
    }
}
