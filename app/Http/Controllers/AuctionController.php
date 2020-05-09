<?php

namespace App\Http\Controllers;

use App\Auction;
use App\AuctionObject;
use App\AuctionParticipants;
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
    public function getActiveAuctions()
    {
        $raw_auctions = new Auction;
        $activeAuctions = json_decode($raw_auctions->all());

        array_filter($activeAuctions, function($auction) {
            return $auction->status == 'active';
        });

        foreach ($activeAuctions as $auction) {
            $objectIds[] = $auction->object_id;
        }

        $auction_objects = json_decode(json_encode($this->getAuctionObjects(AuctionObject::all(), $objectIds)), true);

        foreach ($activeAuctions as $auction) {
            foreach ($auction_objects as $object) {
                if ($object['id'] == $auction->object_id) {
                    $auction->auction_object = $object;
                }
            }
            $auction->participants = $this->getAuctionParticipants(AuctionParticipants::all(), $auction->id);
            $auction->auction_data = $this->getAuctionTypeData($auction->id, $auction->type);
        }

        return $activeAuctions;
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
