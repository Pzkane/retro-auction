<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use App\Offer;
use App\Http\Resources\Offers\Offer as OfferResources;
use App\Traits\OffersTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Illuminate\Support\Facades\Log;

class OfferController extends Controller
{
    use OffersTraits;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offersQuery = Offer::query();

        // offer sorting by creation date
        if (!is_null($request->date)) {
            switch ($request->date) {
                case 'accending':
                    $offersQuery->orderBy('created_at','asc');
                    break;
                
                case 'descending':
                    $offersQuery->orderBy('created_at','desc');
                    break;
            }
        } else {
            $offersQuery->orderBy('created_at','desc');
        }

        // conditions from route query parameters
        if(!is_null($request->title)) {
            $offersQuery->where('title', 'like', '%'.$request->title.'%');
        }

        if(!is_null($request->description)) {
            $offersQuery->where('body', 'like', '%'.$request->description.'%');
        }

        $offers = Offer::all();
        if(!is_null($request->parts)) {
            $offerIds = DB::table('offers_parts')
                ->where('part', 'like', '%'.$request->parts.'%')
                ->groupBy('offer_id')
                ->pluck('offer_id')
                ->toArray();
            Log::info($offerIds);

            $offersQuery->whereIn('id', $offerIds);
        }

        $filterOfferIds = [];
        if(!is_null($request->category)) {
            $offerIds = DB::table('offers_parts')
                ->whereIn('category', (array) $request->category)
                ->groupBy('offer_id')
                ->pluck('offer_id');
            Log::info($offerIds);
            $offersQuery->whereIn('id', $offerIds);
        }

        $offers = $offersQuery;

        $offers = $offers->paginate(5);
        foreach ($offers as $offer) {
            $offer->author_info = $this->getOfferAuthor($offer->author_id);
        }

        return OfferResources::collection($offers)->additional([
            'meta' => [
                'version' => '1.0.0',
                'API_base_url' => url('/')
            ]
        ]);
    }

    public function getUserOffers (Request $request) {
        $offers = Offer::where('author_id', '=', $request->author_id)->get();
        if (sizeof($offers) < 1) {
            return [];
        }

        if (sizeof($offers) > 1) {
            foreach ($offers as $offer) {
                $offer->author_info = $this->getOfferAuthor($request->author_id);
            }
        } else {
            $offers[0]->author_info = $this->getOfferAuthor($request->author_id);
        }

        try {
            return OfferResources::collection($offers);
        } catch (\Throwable $th) {
            return new OfferResources($offers);
        }
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
        $offer = new Offer;
        $offer->author_id = $request->user_id;
        $offer->title = $request->title;
        $offer->body = $request->body;
        $offer->contact_phone = $request->contact_phone;
        $offer->save();

        $this->storeOfferParts($request->parts, $offer->id);

        $previewImage = self::storeImages($offer->id, $request->images, $request->preview_image_id);
        $offer->preview_image = $previewImage;
        $offer->save();

        return response()->json(['status' => 'success'], 200);
    }

    public function storeImages($offerId, $filesObj, $preview_image_id)
    {
        $previewImage = null;
        foreach ($filesObj as $fileId => $file) {
            $newLabel = null;
            $name_passed = false;

            do {
                $newLabel = md5(time()+rand()).'.'.$file->getClientOriginalExtension();
                error_log('newLabel: '.$newLabel);

                if (!DB::table('offers_media')->where('file_name', $newLabel)) {
                    $name_passed = true;
                }
            } while ($name_passed = false);   

            $path = $file->storeAs(
                'public/uploads/offers_media', $newLabel
            );

            DB::table('offers_media')->insert(
                [
                    'offer_id' => $offerId,
                    'photo_path' => Storage::disk('public')->url('uploads/offers_media/'.$newLabel),
                    'file_name' => $newLabel
                ]
            );

            if ($fileId == $preview_image_id) {
                $previewImage = Storage::disk('public')->url('uploads/offers_media/'.$newLabel);
            }
        }
        return $previewImage ? $previewImage : Storage::disk('public')->url('uploads/offers_media/'.$newLabel);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $offer = Offer::find($id);
        $offer['parts'] = $this->showOfferParts($id);
        return new OfferResources($offer);
    }
    
    public function media($id)
    {
        $mediaCollection = collect([]);
        $rawMedia = DB::table('offers_media')->get()->where('offer_id', $id);
        foreach ($rawMedia as $data) {
            $mediaCollection = $mediaCollection->concat(['file_name' => Storage::disk('public')->url('uploads/offers_media/'.$data->file_name)]);
        }

        return response()->json([
            'status' => 'success',
            'photo_path' => $mediaCollection->toArray()
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
