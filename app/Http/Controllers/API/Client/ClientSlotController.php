<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\Controller;
use App\Models\{SlotAvailability};
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClientSlotController extends Controller
{
    public function index(Request $request)
    {
        $sloatData = SlotAvailability::select('id','client_id','slot_id','date')->where('client_id',$request->user()->id)->get();
        if(!empty($sloatData)){
            return response()->json([
                'status' => 200,
                  "message" => "Client Slot Data",
                  "data" => $sloatData
              ]);
           }else{
            return response()->json([
                'status' => 400,
                  "message" => "Client Holiday Data",
                  "data" => []
              ]);
           }
        // echo "<pre>"; print_r($sloatData->toArray()); die;
    }


    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                    'slot_id'=>'required',
                    'date'=>'required',
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
            $clientId = $request->user()->id;
            SlotAvailability::create([
                'date'=>$request->date,
                'slot_id'=>$request->slot_id,
                'client_id'=>$clientId,
                 ]);

                 return response()->json([
                    'status' => 200,
                    'message' => 'Slot Insert successfully',
                ]);
        }
    }

    public function destroy(Request $request,$id)
    {
        $service =  SlotAvailability::find($id);
        if(!empty($service)){

            SlotAvailability::destroy($id);
            return response()->json([
                'status' => 200,
                'message' => 'Slot delete successfully',
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Invalid id shared',
            ]);
        }
    }


}