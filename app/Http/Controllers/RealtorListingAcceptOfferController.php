<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RealtorListingAcceptOfferController
{
    public function __invoke( Offer $offer )
    {
        //Accept the selected offer
        $offer->update(['accepted_at' => now()]);

        //Reject all others
        $offer->listing->offers()->except($offer)
            ->update(['rejected_at' => now()]);

        return redirect()->back()
        ->with(
            'success', 
            "The Offer #{$offer->id} was accepted"
        );
    }
}
