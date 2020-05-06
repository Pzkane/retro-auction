<?php

namespace App\Http\Controllers;

use App\OfferCategory;
use App\Http\Resources\Offers\OfferCategory as OfferCategoryResources;
use Illuminate\Http\Request;

class OfferCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return OfferCategoryResources::collection(OfferCategory::all());
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
    public static function store($arrayData)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OfferCategory  $offerCategory
     * @return \Illuminate\Http\Response
     */
    public function show(OfferCategory $offerCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OfferCategory  $offerCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(OfferCategory $offerCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OfferCategory  $offerCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OfferCategory $offerCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OfferCategory  $offerCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(OfferCategory $offerCategory)
    {
        //
    }
}
