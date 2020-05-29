<?php

namespace App\Http\Controllers;

use App\TopicCategory;
use App\Http\Resources\Topics\TopicCategory as TopicCategoryResources;
use Illuminate\Http\Request;

class TopicCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TopicCategoryResources::collection(TopicCategory::all());
    }
}
