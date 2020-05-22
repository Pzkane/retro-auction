<?php

namespace App\Http\Controllers;

use App\CommercialAuction;
use App\Http\Resources\Auction\CommercialAuction as CommercialAuctionResources;
use App\Traits\AuctionTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommercialAuctionController extends Controller
{
    use AuctionTraits;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CommercialAuctionResources::collection(CommercialAuction::all());
    }

    public function getDetailsByAuctionId($auctionId) {
        return CommercialAuctionResources::collection(CommercialAuction::where('auction_id', $auctionId)->get());
    }

    public function checkBid(Request $request) {
        $auction = new CommercialAuction;
        $auction = $auction->where('auction_id', $request->auction_id)->first();

        if (is_null($auction->highest_bid_user_id)) {
            $auction->highest_bid_user_id = $request->user_id;
            $auction->save();
            
            return response()->json([
                'status' => 'success',
                'msg' => 'Bid was null'
            ], 200);
        }

        $currentBiggestBidUser = $this->findAuctionParticipant($request->auction_id, $auction->highest_bid_user_id);
        Log::info(json_encode($currentBiggestBidUser));
        if ($request->amount > $currentBiggestBidUser->amount) {
            $auction->highest_bid_user_id = $request->user_id;
            $auction->save();

            return response()->json([
                'status' => 'success',
                'msg' => 'Bid replaced'
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'msg' => 'No changes to the bid'
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($auctionId, $startBid, $endDate)
    {
        $commercialAuction = new CommercialAuction();
        $commercialAuction->auction_id = $auctionId;
        $commercialAuction->start_bid = $startBid;
        $commercialAuction->end_date = $endDate;
        $commercialAuction->save();
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
     * @param  \App\CommercialAuction  $commercialAuction
     * @return \Illuminate\Http\Response
     */
    public function show(CommercialAuction $commercialAuction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CommercialAuction  $commercialAuction
     * @return \Illuminate\Http\Response
     */
    public function edit(CommercialAuction $commercialAuction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CommercialAuction  $commercialAuction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CommercialAuction $commercialAuction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CommercialAuction  $commercialAuction
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommercialAuction $commercialAuction)
    {
        //
    }
}
