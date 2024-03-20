<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\{Client,Amenity, Favorite, OutletImage,User,Services,SubCategory,ClientServicePrice,Category};
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{

    public function index()
    {
        $client = Client::all();
        
        return response()->json([
            "success" => true,
            "message" => "client List",
            "data" => $client
        ]);
    }

    public function clientlist(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $lat = $user->latitude;
        $lon = $user->longitude;

        if(!empty($request->latitude) && !empty($request->longitude))
        {
            $lat = $request->latitude;
            $lon = $request->longitude;
        }
        //  echo $lat; echo "/"; echo $lon; die;
        $name = $request->input('search'); 
        $client_id = $request->input('client_id');
        $radius = $request->input('radius');
        
        if(empty($radius)){
            $radius =50; 
        }
        $name = $request->input('search'); 
        $client_id = $request->input('client_id');

            $clients = Client::with(['category', 'service', 'Bankdetails', 'Amenities', 'Image'])
            ->select('clients.*')
            ->addSelect(DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
                * cos(radians(clients.latitude)) 
                * cos(radians(clients.longitude) - radians(" . $lon . ")) 
                + sin(radians(" .$lat. ")) 
                * sin(radians(clients.latitude))) AS distance"))
            // ->groupBy('clients.id','clients.name','clients.email','clients.username','clients.password','clients.category_id','clients.city','clients.clientserviceprices_id','clients.opentime','clients.closetime','clients.outlet_name','clients.outlet_address','clients.latitude','clients.longitude','clients.gumasta','clients.owner_adhar_card','clients.owner_photo','clients.owner_phonenumber','clients.outlet_images','clients.bank_details','clients.amenities_id','clients.rating','clients.status','clients.created_at','clients.updated_at')
            ->having('distance', '<=', $radius);
        
        if($name){
            $clients = $clients->where('outlet_name', 'like', '%' . $name . '%');
        }
        if($client_id){
            $clients = $clients->where('id',$client_id);
        }
        if(isset($request->category_id)){
                    $categorys = $request->category_id;
                   $category = explode(',',$categorys);
                //    echo "<pre>"; print_r($category); die;
            $clients = $clients->whereRaw("find_in_set($categorys,category_id)");
        }
        if(isset($request->limit)){
            if($request->limit != 0){
                $clients = $clients->limit($request->limit);
            }
          }else{
            $clients = $clients->limit(5);
          }

          $clients = $clients->where('status',1);
        
        $clients = $clients->get();
    //   echo "<pre>"; print_r($clients);die;
        $founds = $clients->map(function ($amenity) {
        

            $rental_ids = explode(',', $amenity->outlet_images);

            $outletImages = OutletImage::select('file')
            ->where('id', $rental_ids['0'])
            ->first();
            
      
        $amenities_ids = explode(',', $amenity->amenities_id);
        
        $amenitys =  Amenity::whereIn('id' , $amenities_ids)->distinct()->get();
            // echo "<pre>"; print_r($outletImages->toArray()); die;
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

            return response()->json([
                'status' => 200,
                "message" => "client List",
                "data" => $founds->all(),
            ]);
    }

    public function clientdetails(Request $request , $id)
    {

        $user = Auth::guard('sanctum')->user();
        
        $lat = $user->latitude;
        $lon = $user->longitude;

        $client_id = $id;

            $clients = Client::with(['servicePrice.CatId', 'Bankdetails', 'Amenities', 'Image'])
            ->select('clients.*')
            ->addSelect(DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
                * cos(radians(clients.latitude)) 
                * cos(radians(clients.longitude) - radians(" . $lon . ")) 
                + sin(radians(" .$lat. ")) 
                * sin(radians(clients.latitude))) AS distance"));
            // ->groupBy("clients.id");
            // ->having('distance', '<', $radius);
        
            if($client_id){
                $clients = $clients->where('id',$client_id);
            }
            $clients = $clients->where('status',1);
    
             $clients = $clients->get();
     
      $founds = $clients->map(function ($client) use ($user) {
          $fav = Favorite::where('user_id',$user->id)->where('client_id',$client->id)->first();
          if(!isset($fav->type)){
              $is_favorite=0;
            }else{
                $is_favorite=$fav->type;
            }
            $rental_ids = explode(',', $client->outlet_images);
            
            $outletImages = OutletImage::select('file')
            ->whereIn('id', $rental_ids)    
            ->get();
            
            
            $amenities_ids = explode(',', $client->amenities_id);
            $category_ids = explode(',', $client->category_id);
            
            $categorys =  Category::whereIn('id' , $category_ids)->distinct()->get();
            $amenitys =  Amenity::whereIn('id' , $amenities_ids)->distinct()->get();
            
            //   echo "<pre>"; print_r($client->toArray()); die;
            return [
                    "id" => $client->id,
                    "name" => $client->name,
                    "email " => $client->email,
                    "username" => $client->username,
                    "city" => $client->city,
                    "tax" => $client->tax,
                    "opentime" => $client->opentime,
                    "closetime" => $client->closetime,
                    "outlet_name" => $client->outlet_name,
                    "distance"=>number_format($client->distance,2).' '."Km",
                    'rating'=>number_format($client->rating,1),
                    "latitude"=>$client->latitude,
                    "longitude"=>$client->longitude,
                    "outlet_address" => $client->outlet_address,
                    "gumasta" => $client->gumasta,
                    "owner_adhar_card" => $client->owner_adhar_card,
                    "owner_photo" => $client->owner_photo,
                    "outlet_images" =>$outletImages,
                    "ownerphoto" => $client->image_url,
                    'created_at' => $client->created_at,
                    'updated_at' => $client->updated_at,
                    "category_id" => $categorys,
                    "bank_details" => $client->Bankdetails,
                    "services" => $client->servicePrice,
                    "amenities_id" =>$amenitys,
                    "is_favorite" =>$is_favorite,
                ];
            });

            return response()->json([
                'status' => 200,
                "message" => "client List",
                "data" => $founds->all(),
            ]);
    }

  

     public function nearestOutlet(Request $request)
     {
        $user = Auth::guard('sanctum')->user();
        // echo "<pre>"; print_r($_REQUquest);die;
        $lat = $user->latitude;
        $lon = $user->longitude;

            $radius = $request->radius;

        if(!isset($request->radius)){
            $radius =500; 
        }


            $clients = Client::with(['category', 'Image'])
            ->select('clients.*')
            ->addSelect(DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
                * cos(radians(clients.latitude)) 
                * cos(radians(clients.longitude) - radians(" . $lon . ")) 
                + sin(radians(" .$lat. ")) 
                * sin(radians(clients.latitude))) AS distance"))
            // ->groupBy("clients.id")
            ->having('distance', '<=', $radius);
        
            if(isset($request->limit)){
                if($request->limit != 0){
                    $clients = $clients->limit($request->limit);
                }
              }else{
                $clients = $clients->limit(5);
              }
                if(!empty($request->search)){
                  
              $clients = $clients->where('outlet_name','LIKE','%'.$request->search.'%');
              }
              $clients = $clients->where('status',1);
                $clients = $clients->get();
    //   echo "<pre>"; print_r($clientstoSqle;
        $founds = $clients->map(function ($amenity) {
        
            $rental_ids = explode(',', $amenity->outlet_images);

            $outletImages = OutletImage::select('file')
            ->where('id', $rental_ids['0'])
            ->first();
      
                return [
                    "id" => $amenity->id,
                 
                    "opentime" => $amenity->opentime,
                    "closetime" => $amenity->closetime,
                    "outlet_name" => $amenity->outlet_name,
                    "distance"=>number_format($amenity->distance,2).' '."Km",
                    'rating'=>number_format($amenity->rating,1),
                    "outlet_address" => $amenity->outlet_address,
                    "outlet_images" => $outletImages->image_url,
                ];
            });

            return response()->json([
                'status' => 200,
                "message" => "client List",
                "data" => $founds->all(),
            ]);
     }

     public function setFavorite(Request $request)
     {
        $user = Auth::guard('sanctum')->user();

        $validator = Validator::make(
            $request->all(),
            [
                'type'=>'required',
                'client_id'=>'required',
            ]
        );

        if($validator->fails()){  
            $errors = $validator->errors();

            $response = response()->json([
                'status'=>400,
                'message' => 'Invalid data send',
                'details' => $errors->messages(),
            ]);
        
            throw new HttpResponseException($response);
        }else{
            if($request->type == 2){
                $affectedRows = Favorite::where('client_id',$request->client_id)->where('user_id',$user->id)->delete();
                return response()->json([
                    'status' => 200,
                    "message" => "Remove favorite",
                     ]);
            }elseif($request->type == 1){
                Favorite::create([
                    'user_id'=>$user->id,
                    'type'=>$request->type,
                    'client_id'=>$request->client_id,
                    
                ]);

                return response()->json([
                    'status' => 200,
                    "message" => "Add favorite successfully",
                     ]);
          
                } 
            }
                
      }


      public function topRatedClient(Request $request)
      {
        $user = Auth::guard('sanctum')->user();
        
        $lat = $user->latitude;
        $lon = $user->longitude;
        $name = $request->input('search'); 
            //  $radius =50; 

            $clients = Client::with(['category', 'service', 'Bankdetails', 'Amenities', 'Image'])
            ->select('clients.*')
            ->addSelect(DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
                * cos(radians(clients.latitude)) 
                * cos(radians(clients.longitude) - radians(" . $lon . ")) 
                + sin(radians(" .$lat. ")) 
                * sin(radians(clients.latitude))) AS distance"))
            ->orderBy('rating', 'desc');
            // ->groupBy("clients.id");

            if(isset($request->limit)){
                if($request->limit != 0){
                    $clients = $clients->limit($request->limit);
                }
              }else{
                $clients = $clients->limit(5);
              }
              if($name){
                $clients = $clients->where('outlet_name', 'like', '%' . $name . '%');
            }
              $clients = $clients->where('status',1);
                $clients = $clients->get();
        
        $founds = $clients->map(function ($amenity) {
        
            $rental_ids = explode(',', $amenity->outlet_images);

            $outletImages = OutletImage::select('file')
            ->where('id', $rental_ids['0'])
            ->first();

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

            return response()->json([
                'status' => 200,
                "message" => "client List",
                "data" => $founds->all(),
            ]);
      }


    public function homeOutlets(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        
        $lat = $user->latitude;
        $lon = $user->longitude;
        

              $radius = $request->radius;

        if(!isset($request->radius)){
            $radius =10000; 
        }

            $clients = Client::with(['category', 'service', 'Bankdetails', 'Amenities', 'Image'])
            ->select('clients.*')
            ->addSelect(DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
                * cos(radians(clients.latitude)) 
                * cos(radians(clients.longitude) - radians(" . $lon . ")) 
                + sin(radians(" .$lat. ")) 
                * sin(radians(clients.latitude))) AS distance"))
            ->orderBy('rating', 'desc')
            // ->groupBy("clients.id")
             ->having('distance', '<', $radius);

             if(isset($request->limit)){
                if($request->limit != 0){
                    $clients = $clients->limit($request->limit);
                }
              }else{
                $clients = $clients->limit(5);
              }
              $clients = $clients->where('status',1);
              if(!empty($request->search)){
              $clients = $clients->where('outlet_name','LIKE','%' .$request->search. '%');
              }
                $clients = $clients->get();

    
        $clientsOutlets = $clients->map(function ($client) {
            $outletImageIds = explode(',', $client->outlet_images);
            $outletImages = OutletImage::select('file')
            ->where('id', $outletImageIds[0])
            ->first();

            return [
                "id" => $client->id,
                "name" => $client->name,
                "outlet_name" => $client->outlet_name,
                "number"=> $client->owner_phonenumber,
                "outlet_image"=>$outletImages->image_url,
                "opentime" => $client->opentime,
                "closetime" => $client->closetime,
                 "rating"=> number_format($client->rating,1),
                 "outlet_address" => $client->outlet_address,

              
            ];
          });

          return response()->json([
            'status' => 200,
            "message" => "client List",
            "data" => $clientsOutlets->all(),
        ]);

    }

    // public function clientServices(Request $request, $id)
    
    // {
    //     $clientPrices = ClientServicePrice::where('client_id',$id);
    //         if(!empty($request->category_id)){
    //             $clientPrices=$clientPrices->where('category_id',$request->category_id);
    //         }
    //     $clientPrices = $clientPrices->get();
    //     SubCategory
    //     echo "<pre>"; print_r($clientPrices->toArray());die;
    //              $subcategories=[];
    //             foreach($clientPrices as $clientPrice){
    //                 //  echo "<pre>"; print_r($clientPrice->servicesPrice->toArray());
                    
    //                 $price[] = [
    //                             'id' => $clientPrice->id,
    //                             'title'=> $clientPrice->title,
    //                             'description'=>$clientPrice->description,
    //                             'image'=>$clientPrice->image_url,
    //                             'services'=>$clientPrice->servicesPrice,
    //                            ];
    //             }
    //         //die;
    //     return response()->json([
    //             'status' => 200,
    //             "message" => "client Service List",
    //             "data" => $price,
    //          ]);
    // }


    public function clientServices(Request $request, $id)
    {           
          $category = $request->category_id;

        $clientPrices = SubCategory::with(['catServicesPrice' => fn($query) => $query->where('client_id', $id)->where('category_id', $category)])->whereHas('catServicesPrice', fn ($query) => 
                              $query->where('client_id', $id)->where('category_id', $category)
                      )->get();
  
        return response()->json([
                'status' => 200,
                "message" => "client Service List",
                "data" => $clientPrices,
             ]);
    }
    public function getclientcategories(Request $request, $id)
    {
        $clientSerPrices = ClientServicePrice::where('client_id',$id)->get();
        $ids=[];
        foreach($clientSerPrices as $clientSerPrice){
            $ids[] = $clientSerPrice->category_id;
        }
        $categories = Category::whereIn('id',$ids)->get();
        $cats=[];
        foreach($categories as $category)
        {
            $cats[] =[ 
            'id'=>$category->id,
            'title'=>$category->title,
            'description'=>$category->description,
            'image_url' => $category->image_url,
            ];
        }
        
        return response()->json([
            'status' => 200,
            "message" => "client Category List",
            "data" => $cats,
         ]);
        
    } 

    public function globallySearch(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        
        $lat = $user->latitude;
        $lon = $user->longitude;
        
              $radius = $request->radius;

            $radius =10000; 
        
            $clients = Client::with(['category','Image'])
            ->select('clients.*')
            ->addSelect(DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
                * cos(radians(clients.latitude)) 
                * cos(radians(clients.longitude) - radians(" . $lon . ")) 
                + sin(radians(" .$lat. ")) 
                * sin(radians(clients.latitude))) AS distance"))
            ->orderBy('rating', 'desc')
            // ->groupBy("clients.id")
             ->having('distance', '<=', $radius);

              $clients = $clients->where('status',1);
            //   if(!empty($request->search)){
              $clients = $clients->where('outlet_name','LIKE','%' .$request->search. '%');
            //   }
                $clients = $clients->get();
            // echo "<pre>"; print_r($clients->toArray()); die;
    
        $clientsOutlets = $clients->map(function ($client) {
            $outletImageIds = explode(',', $client->outlet_images);
            $outletImages = OutletImage::select('file')
            ->where('id', $outletImageIds[0])
            ->first();

            return [
                "id" => $client->id,
                "name" => $client->name,
                "outlet_name" => $client->outlet_name,
                "number"=> $client->owner_phonenumber,
                "outlet_image"=>$outletImages->image_url,
                "opentime" => $client->opentime,
                "closetime" => $client->closetime,
                 "rating"=> number_format($client->rating,1),
                 "outlet_address" => $client->outlet_address,

              
            ];
          });

          return response()->json([
            'status' => 200,
            "message" => "client List",
            "data" => $clientsOutlets->all(),
        ]); 
    }

}
