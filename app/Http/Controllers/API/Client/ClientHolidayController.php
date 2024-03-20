<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\Controller;
use App\Models\{Holiday};
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClientHolidayController extends Controller
{
    public function index(Request $request)
    {
       $holiday = Holiday::select('id','date','title','client_id')->where('client_id',$request->user()->id)->get();
       if(!empty($holiday)){
        return response()->json([
            'status' => 200,
              "message" => "Client Holiday Data",
              "data" => $holiday
          ]);
       }else{
        return response()->json([
            'status' => 400,
              "message" => "Client Holiday Data",
              "data" => []
          ]);
       }
    //    echo "<pre>"; print_r($holiday->toArray()); die;
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                    'date'=>'required',
                    'title'=>'required',
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

            Holiday::create([
                'date'=>$request->date,
                'title'=>$request->title,
                'client_id'=>$request->client_id,
                 ]);

                 return response()->json([
                    'status' => 200,
                    'message' => 'Holiday Insert successfully',
                ]);
        }

    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                    'date'=>'required',
                    'title'=>'required',
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
            $userID =$request->user()->id;
            Holiday::find($id)->fill([
                'date'=>$request->date,
                'title'=>$request->title,
                'client_id'=>$userID,
            ])->save();

            return response()->json([
                'status' => 200,
                'message' => 'Holiday update successfully',
            ]);
        }
    }

    public function destroy(Request $request,$id)
    {
        $service =  Holiday::find($id);
        if(!empty($service)){

            Holiday::destroy($id);
            return response()->json([
                'status' => 200,
                'message' => 'Holiday delete successfully',
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Invalid id shared',
            ]);
        }
    }



}