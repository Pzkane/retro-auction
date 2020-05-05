<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferPart extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'offers_parts';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
