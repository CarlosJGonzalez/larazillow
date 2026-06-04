<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class RealtorListingImageController extends Controller
{   
    public function create(Listing $listing)
    {
        $listing->load('myimages');
        return inertia(
            'Realtor/ListingImage/Create',[
                'listing' => $listing,
            ]
        );
    }

public function store(Listing $listing, Request $request)
{
    $request->validate([
        'images.*' => 'required|mimes:jpg,jpeg,png,webp|max:5000',
        'existing_image_path' => 'nullable|string',
    ], [
        'images.*.mimes' => 'Invalid format file. You can use: jpg, jpeg, png, webp',
        'images.*.max' => 'The size must not be greater than 5 megabytes',
    ]);

    // 1) Attach an existing server image
    if ($request->filled('existing_image_path')) {
        $path = $request->string('existing_image_path')->toString();

        // Optional safety check: only allow files from the public images folder
        if (!str_starts_with($path, 'images/')) {
            return redirect()->back()->with('error', 'Invalid image path');
        }

        $image = new ListingImage([
            'filename' => $path,
        ]);

        $listing->myimages()->save($image);

        return redirect()->back()->with('success', 'Existing image attached!');
    }

    // 2) Upload new files
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $path = $file->store('images', 'public');

            $image = new ListingImage([
                'filename' => $path,
            ]);

            $listing->myimages()->save($image);

            // If you are using the symlink public/storage -> storage/app/public,
            // this copy is no longer needed.
            // copy(storage_path('app/public/' . $path), public_path('storage/' . $path));
        }

        return redirect()->back()->with('success', 'Images uploaded!');
    }

    return redirect()->back()->with('error', 'No image was sent');
}    

    // public function store( Listing $listing, Request $request)
    // {
    //     $request->validate([
    //         'images.*' => 'required|mimes:jpg,jpeg,png,webp|max:5000'
    //     ],[
    //         'images.*.mimes' => 'Invalid format file. You can use: jpg, jpeg, png, webp',
    //         'images.*.max' => 'The size must not be greater than 5 megabytes'
    //     ]);

    //     if( $request->hasFile('images') )
    //     {
    //         foreach( $request->file('images') as $file ){
    //             $path = $file->store('images', 'public');

    //             $image = new ListingImage(['filename' => $path ]);
    //             $listing->myimages()->save( $image );
    //             // Then copy it to public_html/storage
    //             copy(
    //                 storage_path('app/public/'.$path),
    //                 public_path('storage/'.$path)
    //             );                 
    //         }
    //     }else{
    //         return redirect()->back()->with( 'error', 'No image was sent' );
    //     }

    //     return redirect()->back()->with('success', 'Images uploaded!');
    // }

    public function destroy( Listing $listing, ListingImage $image )
    {
        Storage::disk('public')->delete( $image->filename );
        $image->delete();

        return redirect()->back()->with( 'success', 'Image deleted!' );
    }
}
