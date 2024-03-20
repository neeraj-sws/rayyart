<?php
   
namespace App\Http\Controllers\API;
   
use App\Models\Advertisment;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Services;

class AdvertismentController extends BaseController
{


    public function index(Request $request)
    {
        $advertisment = Advertisment::where('status',1);
        if(isset($request->limit)){
            if($request->limit != 0){
                $advertisment = $advertisment->limit($request->limit);
            }
          }else{
            $advertisment = $advertisment->limit(5);
          }
            $advertisment = $advertisment->get();

        return response()->json([
            "success" => true,
            "message" => "Advertisment List",
            "data" => $advertisment->all()
        ]);
    }

}