<?php

declare(strict_types=1);

namespace Modules\Notifications\Controllers;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Core\Http\JsonResponse;
use Core\Http\Response;

class NotificationController extends Controller
{
    public function __construct(private readonly NotificationService $notifications)
    {
    }

    public function index(): JsonResponse
    {
        $userId = auth()->id();

        return \Core\Http\ApiResponse::success([
            'notifications' => $userId === null ? [] : $this->notifications->unreadFor($userId),
        ]);
    }

    public function markRead(int $id): Response
    {
        $this->notifications->markRead($id);

        return \Core\Http\ApiResponse::success(null, trans('common.saved'));
    }

    public function markAllRead(): Response
    {
        $userId = auth()->id();
        if ($userId !== null) {
            $this->notifications->markAllRead($userId);
        }

        return \Core\Http\ApiResponse::success(null, trans('common.saved'));
    }
}
