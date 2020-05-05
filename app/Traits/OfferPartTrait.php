<?php

namespace App\Traits;

use App\Http\Controllers\OfferPartController;

/**
 * 
 */
trait OfferPartTrait
{
    public function showOfferParts($offerId) {
        return  OfferPartController::show($offerId);
    }
}
