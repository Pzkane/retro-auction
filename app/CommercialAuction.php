<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommercialAuction extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'commercial_auction';

   /**
    * Indicates if the model should be timestamped.
    *
    * @var bool
    */
   public $timestamps = false;
}
