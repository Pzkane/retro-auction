<?php

namespace App\Http\Controllers;

use App\Auction;
use App\AuctionObject;
use App\AuctionParticipants;
use App\Http\Resources\Auction\AuctionFullDataSet as AuctionFullDataSetResources;
use App\Traits\AuctionTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AuctionController extends Controller
{
    use AuctionTraits;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status = 'active')
    {
        $raw_auctions = new Auction;
        $decoded_auctions = json_decode($raw_auctions->all());

        $filteredAuction = array_filter($decoded_auctions, function($auction) use ($status) {
            return $auction->status == $status;
        });

        if (sizeof($filteredAuction) == 0) {
            return [];
        }

        foreach ($filteredAuction as $auction) {
            $objectIds[] = $auction->object_id;
        }

        $auction_objects = json_decode(json_encode($this->getAuctionObjects(AuctionObject::all(), $objectIds)), true);

        foreach ($filteredAuction as $auction) {
            foreach ($auction_objects as $object) {
                if ($object['id'] == $auction->object_id) {
                    $auction->auction_object = $object;
                }
            }
            $auction->participants = $this->getAuctionParticipants(AuctionParticipants::all(), $auction->id);
            $auction->auction_data = $this->getAuctionTypeData($auction->id, $auction->type);
        }

        return new AuctionFullDataSetResources($filteredAuction);
    }

    public function getUserAuctions(Request $request) {
        $activeAuctions = $this->index();
        $dismissedAuctions = $this->index('dismissed');
        $newAuctions = [];
        for ($i=0; $i < 2; $i++) {
            $filteredAuctions = [];
            if ($i == 0) {
                $auctionBuffer = $activeAuctions;
            } else {
                $auctionBuffer = $dismissedAuctions;
            }

            $count = count(json_decode(json_encode($auctionBuffer)));
            for ($j=0; $j < $count; $j++) {
                $toAdd = false;
                if (isset($auctionBuffer[$j])) {
                    foreach ($auctionBuffer[$j]->participants as $participant) {
                        if ($participant->user_id == $request->user_id) {
                            $toAdd = true;
                        }
                    }
        
                    if ($toAdd) {
                        $filteredAuctions[] = $auctionBuffer[$j];
                    }
                } else {
                    $count++;
                }
            }
            $newAuctions[] = $filteredAuctions;
        }

        return $newAuctions;
    }

    public function finishAuction(Request $request) {
        $auctionToFinish = Auction::find($request->auction_id);
        $auctionToFinish->finished_at = now();
        $auctionToFinish->save();
        return;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auctionObject = $this->createAuctionObject($request->object_name, $request->preview_image);
        $auction = new Auction();
        $auction->object_id = $auctionObject->id;
        $auction->type = $request->type;
        $auction->save();

        switch ($request->type) {
            case 'charity':
                $this->createCharityAuction($auction->id, $request->goal);
                break;
            
            case 'commercial':
                $this->createCommercialAuction($auction->id, $request->start_bid, $request->end_date);
                break;
        }

        return;
    }
}
