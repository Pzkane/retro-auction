<?php

namespace App\Http\Controllers;

use App\Offer;
use App\OfferPart;
use App\Http\Resources\Offer\OfferPart as OfferPartResources;
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
     * @param  \App\OfferPart  $offerPart
     * @return \Illuminate\Http\Response
     */
    public static function show($offerId)
    {
        return OfferPartResources::collection(OfferPart::where('offer_id', $offerId)->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OfferPart  $offerPart
     * @return \Illuminate\Http\Response
     */
    public function edit(OfferPart $offerPart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OfferPart  $offerPart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OfferPart $offerPart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OfferPart  $offerPart
     * @return \Illuminate\Http\Response
     */
    public function destroy(OfferPart $offerPart)
    {
        //
    }
}
