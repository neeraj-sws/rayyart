<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\Controller;
use App\Models\{Client,Amenity, Category,City,State,Slot};
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;

class ClientInfoController extends Controller
{
    public function clientInfo(Request $request)
    {
        $client = Client::with('CityId','CatId:id,title','gumastaImage','Bankdetails')->where('id',$request->user()->id)->first();

        //  echo "<pre>"; print_r($client->toArray()); die;
        if($client){
               $amenityIds = explode(',',$client->amenities_id);
              $amenities =  Amenity::select('id','title','icon')->whereIn('id',$amenityIds)->get();

              $openTime = new DateTime($client->opentime);
              $closeTime = new DateTime($client->closetime);
                
                 $startTime = $openTime->format("h:i A");
                 $endTime = $closeTime->format("h:i A");
                 
            //   echo "<pre>"; print_r($amenities->toArray()); die;
           
            $ClientData = [
                'id'=>  $client->id,
                'name'=> $client->name,
                'email'=> $client->email,
                'latitude'=> $client->latitude,
                'longitude'=> $client->longitude,
                'address'=> $client->outlet_address,
                'outletName' =>$client->outlet_name,   
                'mobile_number'=> $client->owner_phonenumber,
                'ownerAdharCard' =>$client->owner_adhar_card, 
                'city'=>$client->CityId->name,
                'startTime' => $startTime,
                'endTime' => $endTime,
                'owner_photo'=>$client->image_url,
                'gumastaImage'=>$client->gumasta_url, 
                // 'bankDetails'=>$client->bankdetails,
                'amenities'=> $amenities,
                'category'=>$client->CatId,
                ];
                
           return response()->json([
            'status' => 200,
              "message" => "Client Data",
              "data" => $ClientData
          ]);
        }else{
            return response()->json([
                "status" => 400,
                "message" => "Client Data",
                "data" => []
            ]);
          }
    }

    public function clientCategory()
    {
       $allCategories = Category::select('id','title','description','icon')->where('status',1)->get();
      if(!empty($allCategories)){

          foreach($allCategories as $allCategory){
          $categories[] = [
              'id'=>$allCategory->id,
              'title'=>$allCategory->title,
              'description'=>$allCategory->description,
              'image_url'=>$allCategory->image_url,
          ];
        }
        return response()->json([
            'status' => 200,
              "message" => "Categories Data",
              "data" => $categories
          ]);
      }else{
        return response()->json([
            "status" => 200,
            "message" => "Categories Data",
            "data" => []
        ]);
      }
      
    }
    
     public function States()
    {
        $states =  State::select('id','state_title')->where('status',1)->get();
        // echo "<pre>"; print_r($states->toArray()); die;
          if(!empty($states)){
            return response()->json([
              'status' => 200,
                "message" => "States Data",
                "data" => $states
            ]);
          }else{
            return response()->json([
              'status' => 200,
                "message" => "States Data",
                "data" => []
            ]);
          }
    }


  public function Cities($id)
    { 
        $cities =  City::select('id','state_id','name')->where(['state_id' => $id,'status'=>1 ])->get();
          if(!empty($cities)){
            return response()->json([
              'status' => 200,
                "message" => "Cities Data",
                "data" => $cities
            ]);
          }else{
            return response()->json([
              'status' => 200,
                "message" => "Cities Data",
                "data" => []
            ]);
          }
    }

    public function amenitiesList()
    {
         $amenityData = Amenity::select('id','title','description','icon')->where('status',1)->get();

              if(!empty($amenityData)){

                return response()->json([
                  'status' => 200,
                    "message" => "Amenity Data",
                    "data" => $amenityData
                ]);

              }else{

                return response()->json([
                  'status' => 200,
                    "message" => "Amenity Data",
                    "data" => []
                ]);

              }
    }

    public function shopTime()
    {
        $timeSlot = Slot::select('id','start_time')->get();

        if(!empty($timeSlot)){
          return response()->json([
            'status' => 200,
              "message" => "Time Slot Data",
              "data" => $timeSlot
          ]);
        }else{
          return response()->json([
            'status' => 200,
              "message" => "Time Slot Data",
              "data" => []
          ]);
        }
        // echo "<pre>"; print_r($timeSlot->toArray()); die;
    }

}
