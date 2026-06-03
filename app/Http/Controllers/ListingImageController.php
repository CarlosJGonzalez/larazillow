<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ListingImageController
{
    public function library()
    {
        $path = storage_path('app/public/images');

        if (!File::exists($path)) {
            return response()->json([]);
        }

        $images = collect(File::files($path))
            ->filter(function ($file) {
                return in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
            })
            ->map(function ($file) {
                return [
                    'name' => $file->getFilename(),
                    'path' => $file->getFilename(),
                    'src' => asset('storage/images/' . $file->getFilename()),
                ];
            })
            ->values();

        return response()->json($images);    
    }
}