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
}
