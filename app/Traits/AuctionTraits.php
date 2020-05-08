<?php

namespace App\Traits;

use App\Http\Controllers\CharityAuctionController;
use App\Http\Controllers\CommercialAuctionController;

/**
 * 
 */
trait AuctionTraits
{
    public function indexAll() {
        return [
            'charity' => (new CharityAuctionController)->index(),
            'commercial' => (new CommercialAuctionController)->index()
        ];
    }
}
