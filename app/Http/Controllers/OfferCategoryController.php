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
}
