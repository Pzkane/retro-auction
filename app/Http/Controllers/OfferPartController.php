<?php

namespace App\Http\Controllers;

use Log;

use App\Offer;
use App\OfferPart;
use App\Http\Resources\Offers\OfferPart as OfferPartResources;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class OfferPartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return OfferPartResources::collection(OfferPart::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function store($arrayData, $offerId)
    {
        $decodedArrayData = json_decode($arrayData);
        $insertArray = array();

        foreach ($decodedArrayData as $dataChunk) {
            array_push($insertArray, array(
                'part' => $dataChunk->label,
                'category' => $dataChunk->category,
                'offer_id' => $offerId
            ));
        }

        OfferPart::insert($insertArray);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OfferPart  $offerPart
     * @return \Illuminate\Http\Response
     */
    public static function show($offerId)
    {
        return OfferPartResources::collection(OfferPart::where('offer_id', $offerId)->get());
    }
}
