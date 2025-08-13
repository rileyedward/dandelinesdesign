<?php

namespace App\Http\Controllers;

use App\Contracts\NotificationServiceInterface;
use App\Http\Requests\NotificationRequest;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends BaseController
{
    protected string $modelClass = Notification::class;

    protected $serviceInterface = NotificationServiceInterface::class;

    protected ?string $requestClass = NotificationRequest::class;

    public function getUnread(Request $request): JsonResponse
    {
        $notifications = Notification::query()
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($notifications);
    }

    public function markAsRead(Request $request, int $id): JsonResponse
    {
        $notification = Notification::query()
            ->findOrFail($id);

        $notification->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function markAllAsRead(Request $request): JsonResponse
    {
        Notification::query()
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
}
