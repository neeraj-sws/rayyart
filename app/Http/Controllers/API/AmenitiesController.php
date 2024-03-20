<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;

class AmenitiesController extends BaseController
{
    public function index()
    {
        $amenities = Amenity::all();
        
        return response()->json([
            "success" => true,
            "message" => "Amenities List",
            "data" => $amenities
        ]);
    }

    public function amenitieslist(Request $request)
    {
        $name = $request->input('search'); 
        $amenities_id = $request->input('amenities_id');
        $amenities = Amenity::with(['photo']);
        if ($name) {
            $amenities = $amenities->where('title' , 'like', '%' . $name . '%');
        }elseif($amenities_id){
            $amenities= $amenities->where('id' , $amenities_id);
        }
        if(isset($request->limit)){
            if($request->limit != 0){
                $amenities = $amenities->limit($request->limit);
            }
          }else{
            $amenities = $amenities->limit(5);
          }
            $amenities = $amenities->get();
    

        $founds = $amenities->map(function ($amenity) {

            return [
                "id" => $amenity->id,
                "title" => $amenity->title,
                "description" => $amenity->description,
                "status" => $amenity->status,
                "icon" => $amenity->image_url,
                'created_at' => $amenity->created_at,
                'updated_at' => $amenity->updated_at,
            ];
        });

        return response()->json([
            'status' => 200,
            "message" => "Amenities List",
            "data" => $founds->all(),
        ]);
    }
}
