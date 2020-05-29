<?php

namespace App\Http\Controllers;

use App\AuctionObject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuctionObjectController extends Controller
{
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
}
