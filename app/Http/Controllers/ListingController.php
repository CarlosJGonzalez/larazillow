<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Listing::class, 'listing');
    }

    /**
     * Display a listing of the resource.
     */
    public function index( Request $request)
    {     
        $filters = $request->only(['priceFrom', 'priceTo', 'areaFrom', 'areaTo', 'beds', 'baths']);        
        $query = Listing::mostRecent()->filter( $filters );
        if( $request->user() ){
            $query->where('by_user_id', $request->user()->id);
        }
        return inertia(
            'Listing/Index',
            [
                'filters'   => $filters,
                'listings'   => $query
                    ->filter($filters)
                    ->withoutSold()
                    ->orderBy('id', 'desc')
                    ->paginate(9)
                    ->withQueryString()
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show( Listing $listing )//Route Model Binding
    {
        $listing->load(['myimages']);
        $offer = !Auth::user() ? null : $listing->offers()->byMe()->first();

        return inertia(
            'Listing/Show',
            [
                'listing'   => $listing,
                'hasOffer'     => $offer
            ]
        );
    }
}
