<?php

namespace App\Http\Controllers;

use App\AuctionObject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuctionObjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($objectName, $previewImage)
    {
        $newLabel = md5(time()+rand()).'.'.$previewImage->getClientOriginalExtension();
        $previewImage->storeAs(
            'public/uploads/auctions/auction_objects', $newLabel
        );
        $imagePath = Storage::disk('public')->url('uploads/auctions/auction_objects/'.$newLabel);

        $auctionObject = new AuctionObject();
        $auctionObject->object_type_id = 1; // car
        $auctionObject->name = $objectName;
        $auctionObject->preview_image = $imagePath;
        $auctionObject->save();
        return $auctionObject;
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
     * @param  \App\AuctionObject  $auctionObject
     * @return \Illuminate\Http\Response
     */
    public function show(AuctionObject $auctionObject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AuctionObject  $auctionObject
     * @return \Illuminate\Http\Response
     */
    public function edit(AuctionObject $auctionObject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AuctionObject  $auctionObject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AuctionObject $auctionObject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AuctionObject  $auctionObject
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuctionObject $auctionObject)
    {
        //
    }
}
