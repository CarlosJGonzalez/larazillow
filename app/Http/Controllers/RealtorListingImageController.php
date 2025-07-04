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

    public function store( Listing $listing, Request $request)
    {
        $request->validate([
            'images.*' => 'required|mimes:jpg,jpeg,png,webp|max:5000'
        ],[
            'images.*.mimes' => 'Invalid format file. You can use: jpg, jpeg, png, webp',
            'images.*.max' => 'The size must not be greater than 5 megabytes'
        ]);

        if( $request->hasFile('images') )
        {
            foreach( $request->file('images') as $file ){
                $path = $file->store('images', 'public');

                $image = new ListingImage(['filename' => $path ]);
                $listing->myimages()->save( $image );
            }
        }

        return redirect()->back()->with('success', 'Images uploaded!');
    }

    public function destroy( Listing $listing, ListingImage $image )
    {
        Storage::disk('public')->delete( $image->filename );
        $image->delete();

        return redirect()->back()->with( 'success', 'Image deleted!' );
    }
}
