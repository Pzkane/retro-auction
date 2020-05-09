<?php

namespace App\Traits;

// use App\Http\Controllers\AuctionParticipantsController;
use App\Http\Controllers\CharityAuctionController;
use App\Http\Controllers\CommercialAuctionController;
use App\Http\Resources\Auction\AuctionParticipants as AuctionParticipantsResources;
use App\Http\Resources\Auction\AuctionObject as AuctionObjectResources;

/**
 * 
 */
trait AuctionTraits
{
    public function indexActive() {
        // $auctions = new AuctionParticipantsController;

        return [
            'charity' => (new CharityAuctionController)->getActive(),
            'commercial' => (new CommercialAuctionController)->getActive()
        ];
    }

    public function getAuctionObjects($auctions_Model, $objectIds) {
        return AuctionObjectResources::collection($auctions_Model->whereIn('id', $objectIds));
    }

    public function getAuctionParticipants($auctionParticipants_Model, $auctionId) {
        return AuctionParticipantsResources::collection($auctionParticipants_Model->where('auction_id', $auctionId));
    }

    public function getAuctionTypeData ($auctionId, $auctionType) {
        switch ($auctionType) {
            case 'charity':
                return (new CharityAuctionController)->getDetailsByAuctionId($auctionId);

            case 'commercial':
                return (new CommercialAuctionController)->getDetailsByAuctionId($auctionId);
        }
    }
}
