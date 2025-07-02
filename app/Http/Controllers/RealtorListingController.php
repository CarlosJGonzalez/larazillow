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
                ->listings()
                //->mostRecent()
                ->filter($filters)
                ->get()
            ]
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
}
