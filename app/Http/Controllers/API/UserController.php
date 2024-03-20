<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\{Amenity, Client,ClientRating,Favorite, OutletImage, User,State,City};
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{
   
     public function info(Request $request)
    {
        // echo "<pre>"; print_r($request->guard('user')->user()); die;
        if ($request->user()) {
            $user = User::select('id','name','email','image','mobile_number','latitude','longitude','address')->where('id',$request->user()->id)->first();
            if($user){
                
                 
               $userData = [
                  'id'=>  $user->id,
                  'name'=> $user->name,
                  'email'=> $user->email,
                  'image'=> url('/uploads/user/'.$user->image),
                  'mobile_number'=> $user->mobile_number,
                  'latitude'=> $user->latitude,
                  'longitude'=> $user->longitude,
                  'address'=> $user->address,
                  ];
                  
             return response()->json([
              'status' => 200,
                "message" => "User Data",
                "data" => $userData
            ]);
            }else{
              return response()->json([
                  "status" => 400,
                  "message" => "User Data",
                  "data" => []
              ]);
            }

          }
          
    }

    public function myFavorites(Request $request)
    {
      $user = Auth::guard('sanctum')->user();
      $lat = $user->latitude;
        $lon = $user->longitude;
        $clientIds= [];
        $name = $request->input('search');
         $favIDs = Favorite::where('user_id', $user->id)->where('type','=',1)->get();
          foreach($favIDs as $favId){
            $clientIds[] =$favId->client_id;
          }
           
        $clients = Client::with(['category', 'service', 'Bankdetails', 'Amenities', 'Image'])
        ->select('clients.*')
        ->addSelect(DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
            * cos(radians(clients.latitude)) 
            * cos(radians(clients.longitude) - radians(" . $lon . ")) 
            + sin(radians(" .$lat. ")) 
            * sin(radians(clients.latitude))) AS distance"))
        // ->groupBy("clients.id")
        ->whereIn('clients.id', $clientIds);
        if($name){
          $clients = $clients->where('outlet_name', 'like', '%' . $name . '%');
      }
        $clients = $clients->where('status',1);
        $clients = $clients->get();

        $favClientData = $clients->map(function ($amenity) {

          $rental_ids = explode(',', $amenity->outlet_images);
           $outletImages = OutletImage::select('file') ->where('id', $rental_ids['0'])->first();
          $amenities_ids = explode(',', $amenity->amenities_id);
            $amenitys =  Amenity::whereIn('id' , $amenities_ids)->distinct()->get();

              return [
                  "id" => $amenity->id,
                  "opentime" => $amenity->opentime,
                  "closetime" => $amenity->closetime,
                  "outlet_name" => $amenity->outlet_name,
                  'rating'=>number_format($amenity->rating,1),
                  "outlet_address" => $amenity->outlet_address,
                     "outlet_images" =>$outletImages->image_url,
              ];
          });
          
      if($clients){
        return response()->json([
         'status' => 200,
           "message" => "Favorite Client",
           "data" => $favClientData->all()
       ]);
       }else{
         return response()->json([
             "status" => 400,
             "message" => "Favorite Client",
             "data" => []
         ]);
       }
    }


    public function setClientRating(Request $request)
    { 
      $user = Auth::guard('sanctum')->user();

      $validator = Validator::make(
          $request->all(),
          [
              'rating'=>'required|numeric',
              'review'=>'required',
              'client_id' =>'required',
          ]
      );
      if($validator->fails()){  
        $errors = $validator->errors();

        $response = response()->json([
            'status'  =>   400,
            'message' => 'Invalid data send',
            'details' => $errors->messages(),
        ]);
    
        throw new HttpResponseException($response);
      }else{

        $cRating_id =  ClientRating::create([
                          'user_id'  => $user->id,
                          'rating'   => $request->rating,
                          'review'   => $request->review,
                          'client_id'=> $request->client_id,
                          ]);

                          $averageRating = ClientRating::where('client_id', $cRating_id->client_id)
                          ->avg('rating');
                          Client::find($cRating_id->client_id)->fill(['rating'=>$averageRating])->save(); 

          return response()->json([
              'status' => 200,
              "message" => "Add rating successfully",
              ]);

      }


    }

    public function getStates(Request $request)
    {
       $states = State::select('id','state_title')->where('status',1)->get();
       if(!empty($states))
       {
            return response()->json([
              'status' => 200,
                "message" => "State Data",
                "data" => $states
            ]);
       }else{
        return response()->json([
          "status" => 400,
          "message" => "State Data",
          "data" => []
      ]);
       }
    }

    public function getCities(Request $request)
    {
      // echo "<pre>"; print_r($request->toArray()); die;
      $cities = City::select('id','name','state_id','latitude','longitude')->where('status',1)->where('state_id',$request->id)->get();

          if(!empty($cities))
          {
              return response()->json([
                'status' => 200,
                  "message" => "State Data",
                  "data" => $cities
              ]);
          }else{
          return response()->json([
            "status" => 400,
            "message" => "State Data",
            "data" => []
        ]);
          }
    }

}
