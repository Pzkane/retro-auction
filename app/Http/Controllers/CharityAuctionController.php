<?php

namespace App\Http\Controllers;

use App\CharityAuction;
use App\Http\Resources\Auction\CharityAuction as CharityAuctionResources;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CharityAuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CharityAuctionResources::collection(CharityAuction::all());
    }

    public function getDetailsByAuctionId($auctionId) {
        return CharityAuctionResources::collection(CharityAuction::where('auction_id', $auctionId)->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($auctionId, $goal)
    {
        $charityAuction = new CharityAuction();
        $charityAuction->auction_id = $auctionId;
        $charityAuction->goal = $goal;
        $charityAuction->save();
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
     * @param  \App\CharityAuction  $charityAuction
     * @return \Illuminate\Http\Response
     */
    public function show(CharityAuction $charityAuction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CharityAuction  $charityAuction
     * @return \Illuminate\Http\Response
     */
    public function edit(CharityAuction $charityAuction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CharityAuction  $charityAuction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CharityAuction $charityAuction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CharityAuction  $charityAuction
     * @return \Illuminate\Http\Response
     */
    public function destroy(CharityAuction $charityAuction)
    {
        //
    }
}
