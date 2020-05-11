<?php

namespace App\Http\Controllers;

use App\Auction;
use App\AuctionObject;
use App\AuctionParticipants;
use App\Http\Resources\Auction\AuctionFullDataSet as AuctionFullDataSetResources;
use App\Traits\AuctionTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
