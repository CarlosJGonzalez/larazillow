<?php

namespace App\Http\Controllers;

use App\Models\Offer;
//use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RealtorListingAcceptOfferController extends Controller
{
    public function __invoke( Offer $offer )
    {
        try{
            $listing = $offer->listing;
    
            //Accept the selected offer
            $offer->update(['accepted_at' => now()]);
    
            $listing->sold_at = now();
            $listing->save();
    
            //Reject all others
            $listing->offers()->except($offer)
                ->update(['rejected_at' => now()]);
    
            return redirect()->back()
            ->with(
                'success', 
                "The Offer #{$offer->id} was accepted"
            );
        }catch( \Throwable $thro ){
            die( $thro->getMessage());
        }
    }
}