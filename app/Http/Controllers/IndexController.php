<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController
{
    public function index()
    {
        return inertia('Index/Index',
            [
                'message'   => 'A message from the main page'
            ]
        );
    }

    public function show()
    {
        return inertia('Index/Show');
    }
}
