<?php

namespace App\Http\Controllers;

use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class NotificationController extends Controller
{
    use AuthorizesRequests;
    public function index( Request $request): Response
    {
        return inertia(
            'Notification/Index',
            [
                'notifications' =>$request->user()
                    ->notifications()->paginate(10)
            ]
        );
    }

    public function update( Request $request, DatabaseNotification $notification )
    {
        $user = Auth::user();
        $notification = $user->unreadNotifications()->find( $request->notification->id );
        if( $notification && $notification->notifiable_id == $user->id )
        {
            $notification->markAsRead();
            return back()->with('success', 'Notification marked as read.');
        }

        return back()->with('error', 'Notification not found or already read.');
    }
}
