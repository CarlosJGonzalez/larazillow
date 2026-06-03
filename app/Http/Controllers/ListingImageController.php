<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class ListingImageController extends Controller
{
    public function library()
    {
        $files = Storage::disk('public')->allFiles('images');

        $images = collect($files)
            ->filter(function (string $path) {
                return in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), [
                    'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'
                ], true);
            })
            ->map(function (string $path) {
                return [
                    'name' => basename($path),
                    'path' => $path,
                    'src' => asset('storage/' . $path),
                ];
            })
            ->values();

        return response()->json($images);
    }
}