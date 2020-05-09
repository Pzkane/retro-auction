<?php

namespace App\Http\Controllers;

use App\CommercialAuction;
use App\Http\Resources\Auction\CommercialAuction as CommercialAuctionResources;
use Illuminate\Http\Request;

class CommercialAuctionController extends Controller
{
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
