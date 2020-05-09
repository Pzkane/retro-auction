<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuctionParticipants extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'auction_participants';

   /**
    * Indicates if the model should be timestamped.
    *
    * @var bool
    */
   public $timestamps = false;
}
