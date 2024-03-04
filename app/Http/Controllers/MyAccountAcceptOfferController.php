<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class MyAccountAcceptOfferController extends Controller
{   
    // __invoke is the way in Laravel to define controllers that only have one single action "Single Action Controller"
    public function __invoke(Offer $offer)
    {
        // Get the listing from the offer, and authorize the user to update it
        $listing = $offer->listing;
        $this->authorize('update', $listing);

        // Accept selected offer
        $offer->update(['accepted_at' => now()]);

        $listing->sold_at = now();
        $listing->save();

        // Reject all other offers
        $listing->offers()->except($offer)
            ->update(['rejected_at' => now()]);

        return redirect()->back()
            ->with(
                'success',
                "Offer #{$offer->id} accepted, other offers rejected"
            );
    }
}
