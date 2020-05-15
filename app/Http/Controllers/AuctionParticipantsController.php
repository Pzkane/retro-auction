<?php

namespace App\Http\Controllers;

use App\AuctionParticipants;
use App\Http\Resources\Auction\AuctionParticipants as AuctionParticipantsResources;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AuctionParticipantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AuctionParticipantsResources::collection(Auctionparticipants::all());
    }

    public function indexByAuctionType($auctionType)
    {
        return AuctionParticipantsResources::collection(Auctionparticipants::where('auction_type', $auctionType));
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
        $participant = new AuctionParticipants;
        $participant->auction_id = $request->auction_id;
        $participant->user_id = $request->user_id;
        $participant->amount = $request->amount;
        $participant->save();

        return response()->json(['status' => 'success'], 200);
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
