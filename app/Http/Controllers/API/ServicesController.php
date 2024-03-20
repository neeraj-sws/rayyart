<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Services;
use Illuminate\Support\Facades\Validator;

class ServicesController extends BaseController
{
  
    public function index()
    {    
        $services = Services::get()->toArray();
        return response()->json([
            'success' => true,
            'data' => $services
        ]);
    }

    public function serviceslist(Request $request)
    {
        $name = $request->input('search'); 
        $services = Services::with(['photo']);
        if ($name) {
            $services= $services->where('title' , 'like', '%' . $name . '%');
        }
        if(isset($request->limit)){
            if($request->limit != 0){
                $services = $services->limit($request->limit);
            }
          }else{
            $services = $services->limit(5);
          }
            $services = $services->get();

        $founds = $services->map(function ($amenity) {
 
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
             "message" => "Services List",
             "data" => $founds->all(),
         ]);

    }

}
