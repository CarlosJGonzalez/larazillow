<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
