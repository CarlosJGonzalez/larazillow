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
                    ->orderBy('id', 'desc')
                    ->paginate(9)
                    ->withQueryString()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia( 'Listing/Create' );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->user()->listings()->create( 
            $request->validate([
                'beds' => 'required|integer|min:1|max:20',
                'baths' => 'required|integer|min:1|max:5',
                'area' => 'required|integer|min:500|max:4000',
                'city' => 'required',
                'street' => 'required',
                'street_nr' => 'required|integer|min:1|max:2300',
                'code' => 'required',
                'price' => 'required|integer|min:123450|max:20000000'
            ]) 
        );

        return redirect()->route('listing.index')
            ->with( 'success', 'Listing was created!');
    }

    /**
     * Display the specified resource.
     */
    public function show( Listing $listing )//Route Model Binding
    {
        // if( !Auth::user() || Auth::user()->cannot('view', $listing ) ){
        //     abort( 403 );
        // }
        
        // if( !$this->authorize('view', $listing ) ){
        //     abort( 403 );
        // }
        return inertia(
            'Listing/Show',
            [
                'listing'   => $listing
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( Listing $listing )
    {
        return inertia(
            'Listing/Edit',
            [
                'listing'   => $listing
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing )
    {
        $listing->update( 
            $request->validate([
                'beds' => 'required|integer|min:1|max:20',
                'baths' => 'required|integer|min:1|max:5',
                'area' => 'required|integer|min:500|max:4000',
                'city' => 'required',
                'street' => 'required',
                'street_nr' => 'required|integer|min:1|max:2300',
                'code' => 'required',
                'price' => 'required|integer|min:123450|max:20000000'
            ]) 
        );
        return redirect()->route('listing.index')
            ->with( 'success', 'Listing was updated!');        
    }
}
