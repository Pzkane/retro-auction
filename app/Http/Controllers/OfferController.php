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

class OfferController extends Controller
{
    use OffersTraits;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = Offer::paginate(5);
        return OfferResources::collection($offers)->additional([
            'meta' => [
                'version' => '1.0.0',
                'API_base_url' => url('/')
            ]
        ]);
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
        $offer->contact_email = $request->contact_email;
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
