<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RealtorListingController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Listing::class, 'listing');
    }

    public function index( Request $request )
    {
        $filters = [
            'deleted'   => $request->boolean('deleted'),
            ...$request->only(['by', 'order'])
        ];

        return inertia(
            'Realtor/Index',
            [
                'filters'  => $filters,
                'listings' => Auth::user()
                    ->myListings()
                    ->withCount('myimages')
                    ->withCount('offers')
                    ->filter($filters)
                    ->paginate(5)
                    ->withQueryString()
            ]
        );
    }

    public function show( Listing $listing )
    {
        return inertia( 'Realtor/Show',
            ['listing' => $listing->load([
                'offers' => function($query){
                    $query->orderBy('amount', 'desc');
                }, 'offers.bidder' => function($query){
                    $query->select('id', 'name');
                }
            ])]
        );
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing )
    {
        $listing->deleteOrFail();
        
        return redirect()->back()
            ->with( 'success','Listing deleted');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit( Listing $listing )
    {
        return inertia(
            'Realtor/Edit',
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
                'baths' => 'required|decimal:0,2|min:1|max:5',
                'area' => 'required|decimal:0,2|min:500|max:4000',
                'city' => 'required',
                'street' => 'required',
                'street_nr' => 'required|integer|min:1|max:2300',
                'code' => 'required',
                'price' => 'required|decimal:0,2|min:123450|max:20000000'
            ]) 
        );
        return redirect()->route('realtor.listing.index')
            ->with( 'success', 'Listing was updated!');        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia( 'Realtor/Create' );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->user()->myListings()->create( 
            $request->validate([
                'beds' => 'required|integer|min:1|max:20',
                'baths' => 'required|decimal:0,2|min:1|max:5',
                'area' => 'required|decimal:0,2|min:500|max:4000',
                'city' => 'required',
                'street' => 'required',
                'street_nr' => 'required|integer|min:1|max:2300',
                'code' => 'required',
                'price' => 'required|decimal:0,2|min:123450|max:20000000'
            ]) 
        );

        return redirect()->route('realtor.listing.index')
            ->with( 'success', 'Listing was created!');
    }

    public function restore( Listing $listing )
    {
        $listing->restore();
        return redirect()->back()->with('success', 'The listing was restored!');
    }
}
