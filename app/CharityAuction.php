<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CharityAuction extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'charity_auction';

   /**
    * Indicates if the model should be timestamped.
    *
    * @var bool
    */
   public $timestamps = false;
}
