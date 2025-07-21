<?php

namespace App\Http\Controllers;

use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class NotificationController extends Controller
{
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
}
