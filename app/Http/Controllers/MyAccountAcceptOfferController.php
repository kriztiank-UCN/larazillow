<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class MyAccountAcceptOfferController extends Controller
{   
    // __invoke is the way in Laravel to define controllers that only have one single action "Single Action Controller"
    public function __invoke(Offer $offer)
    {
        // Accept selected offer
        $offer->update(['accepted_at' => now()]);

        // Reject all other offers
        $offer->listing->offers()->except($offer)
            ->update(['rejected_at' => now()]);

        return redirect()->back()
            ->with(
                'success',
                "Offer #{$offer->id} accepted, other offers rejected"
            );
    }
}
