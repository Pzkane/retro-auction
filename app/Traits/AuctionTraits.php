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

        try {
            $index = 0;
            foreach ($participantsInfo as $participant) {
                $participant->username = $usersInfo[$index]->username;
                $participant->email = $usersInfo[$index]->email;
                $participant->avatar_path = $usersInfo[$index]->avatar_path;
                $index++;
            }
        } catch (\Throwable $err) {
            $participantsInfo->username = $usersInfo[0]->username;
            $participantsInfo->email = $usersInfo[0]->email;
            $participantsInfo->avatar_path = $usersInfo[0]->avatar_path;
        }
        
        return AuctionParticipantsResources::collection($participantsInfo);
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
