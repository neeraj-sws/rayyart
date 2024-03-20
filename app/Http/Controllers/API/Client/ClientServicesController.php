<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\Controller;
use App\Models\{ClientServicePrice,Services};
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClientServicesController extends Controller
{
    public function getServices(Request $request)
    {
        
        // if(!empty($request->user()->id)){echo "user id"; }else{echo "notuserid"; } die;
        $clientServices = ClientServicePrice::with('category:id,title')->select('id','price','services','category_id','sub_category_id')->where('client_id',$request->user()->id)->get();

            if(!empty($clientServices)){
               $clientServeData =[];
                foreach($clientServices as $clientSercice){
    
                    if($clientSercice->sub_category_id == 1){
                        $sub_category = "Male";
                    }else if($clientSercice->sub_category_id == 2){
                        $sub_category = "Female";
                    }
                    $clientServeData[] = [
                        'id'=> $clientSercice->id,
                        'price'=> $clientSercice->price,
                        'services' =>$clientSercice->services,
                        'category_id' => $clientSercice->category->title,
                        'sub_category_id'=>$sub_category,
                    ];
    
                }

                return response()->json([
                    'status' => 200,
                      "message" => "Client Services Data",
                      "data" => $clientServeData
                  ]);
            }else{
                return response()->json([
                    'status' => 200,
                      "message" => "Client Services Data",
                      "data" => []
                  ]);
            }

     
        // echo "<pre>"; print_r($clientServeData); die;
    }
    
    public function addServices(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'price.*'=>'required',
                'services.*'=>'required',
                'category_id.*'=>'required',
                'sub_category_id.*'=>'required',
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
                $data =  count($request->all()); 
                $first =$request->all();
                for($i = 0; $i < $data; $i++){
                  
           $clientServices[] = ClientServicePrice::create([
                'price'=>$request[$i]['price'],
                'services'=>$request[$i]['services'],
                'category_id'=>$request[$i]['category_id'],
                'sub_category_id'=>$request[$i]['sub_category_id'],
                'client_id'=>$request[$i]['client_id']
                 ]);
                }
                return response()->json([
                    'status' => 200,
                    'message' => 'Service Insert successfully',
                ]);
        }
    }

    public function updateServices(Request $request,$id)
    {
        // echo "<pre>"; print_r($request->all());die;
        $validator = Validator::make(
            $request->all(),
            [
                    'price'=>'required',
                    'services'=>'required',
                    'category_id'=>'required',
                    'sub_category_id'=>'required',
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

            ClientServicePrice::find($id)->fill([
                'price'=>$request->price,
                'services'=>$request->services,
                'category_id'=>$request->category_id,
                'sub_category_id'=>$request->sub_category_id,
            ])->save();

            return response()->json([
                'status' => 200,
                'message' => 'Service update successfully',
            ]);
        }
    }
    
     public function clientServices(Request $request)
    {
        $clientservices = Services::select('id','title')->get();

         $founds = $clientservices->map(function ($clientservices) {
            return [
                "id" => $clientservices->id,
                "title" => $clientservices->title,
            ];
        });
      
        return response()->json([
            'status' => 200,
            "message" => "Client Services List",
            "data" => $founds->all(),
        ]);
    }


    public function deleteServices(Request $request,$id)
    {
       $service =  ClientServicePrice::find($id);
        if(!empty($service)){

            ClientServicePrice::destroy($id);
            return response()->json([
                'status' => 200,
                'message' => 'Service delete successfully',
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Invalid id shared',
            ]);
        }
    }

}