<?php

namespace App\Traits;

// use App\Http\Controllers\AuctionParticipantsController;
use App\Http\Controllers\CharityAuctionController;
use App\Http\Controllers\CommercialAuctionController;
use App\Http\Controllers\UserController;
use App\Http\Resources\Auction\AuctionParticipants as AuctionParticipantsResources;
use App\Http\Resources\Auction\AuctionObject as AuctionObjectResources;
use Illuminate\Support\Facades\Log;

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
        $participantsInfo = $auctionParticipants_Model->where('auction_id', $auctionId);

        $userIds = [];
        foreach ($participantsInfo as $participant_data_chunk) {
            $userIds[] = $participant_data_chunk->user_id;
        }
        $usersInfo = (new UserController)->findByIDs($userIds);

        if (!is_array($participantsInfo)) {
            $participantsInfo = (array) $participantsInfo;
        }
        if (!is_array($usersInfo)) {
            $usersInfo = (array) $usersInfo;
        }

        return AuctionParticipantsResources::collection(array_merge($participantsInfo, $usersInfo));
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
