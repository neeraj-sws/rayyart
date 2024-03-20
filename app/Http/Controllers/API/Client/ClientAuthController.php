<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\Controller;
use App\Models\{Bank_detail, Client, ClientAmenity, Upload,OutletImage ,City,State};
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ClientAuthController extends Controller
{   
    
    public function register(Request $request):JsonResponse
    {  
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email'=>'required',
            'username'=>'required',
            'password' => 'required|min:6',
            'owner_phonenumber'=>'required|min:10',
            // 'state_id' => 'required', 
            // 'city'=>'required',
            'category_id'=>'required',
            'amenities_id'=>'required',
             'outlet_name'=>'required',
            //  'bank_name'=>'required',
            //  'account_holder_name'=>'required',
            //  'account_number'=>'required',
            //  'ifsc_code'=>'required',
             'outlet_address'=>'required',
             'owner_adhar_card'=>'required'
             
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            $response = response()->json([
                'status'  =>   400,
                'message' => 'Invalid data send',
                'details' => $errors->messages(),
            ]);
        
            throw new HttpResponseException($response);
        }
    
        try {

            if(!isset($request->latitude)){
                $request->latitude ="22.9675929";
                 
          }elseif(empty($request->latitude)){
              $request->latitude ="22.9675929";
          }

          if(!isset($request->longitude)){
              $request->longitude ="76.0534454";
          }elseif(empty($request->longitude)){
              $request->longitude ="76.0534454";
          }
          
          $client = Client::create([
              'name'=> $request->name,
              'email'=> $request->email,
              'username'=> $request->username,
              'password'=>bcrypt($request->password),
              'owner_phonenumber'=>$request->owner_phonenumber,
              'state_id'=>$request->state_id,
              'city'=>$request->city,
              'category_id'=> $request->category_id,
              'amenities_id'=> $request->amenities_id,
              'opentime'=> $request->opentime,
              'closetime'=> $request->closetime,
              'latitude'=> $request->latitude,
              'longitude'=> $request->longitude,
              'outlet_name'=>$request->outlet_name,
              'outlet_address'=> $request->outlet_address,
              'tax'=> $request->tax,
              'owner_adhar_card'=>$request->owner_adhar_card,
            ]);

            // $accInfo = Bank_detail::create([
            //     'acc_hold_name'=>$request->account_holder_name,
            //     'account_number'=>$request->account_number,
            //     'bank_name'=>$request->bank_name,
            //     'ifsc_code'=>$request->ifsc_code,
            //     'client_id'=>$client->id,
            // ]);
            // $updatInfo = Client::find($client->id)->fill(['bank_details'=>$accInfo->id])->save();
        

            $success['clientToken'] = $client->createToken('MyApp',['client'])->plainTextToken;
            $success['name'] = $client->name;
            $success['email'] = $client->email;

          $client->tokens->each(function($token, $key) {
              $expirationTime = now()->addMonths(1);
              $token->expires_at = $expirationTime;
              $token->save(); 
             });
          
      return response()->json([
          'status' => 200,
          'message' => 'Client registered successfully',
          'data' => $success,
      ]);

      } catch (\Exception $e) {
          return response()->json([
              'status' => 400, 
              'message' => 'Client with this email already exists',
              'data' => [],
          ]);
      }
     }
    
    
    
    
    public function login(Request $request): JsonResponse
    {
        // echo "<pre>"; print_r($request->all()); die;
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
      
        if($validator->fails()){
         
            $errors = $validator->errors();

            $response = response()->json([
                'status'  =>   400,
                'message' => 'Invalid data send',
                'details' => $errors->messages(),
            ]);
        
            throw new HttpResponseException($response);       
        }

        if(Auth::guard('client')->attempt(['email' => $request->email, 'password' =>  $request->password])){ 
         
            $client = Auth::guard('client')->user();
                if($client->status == 1){

                    $success['clientToken'] = $client->createToken('MyApp',['client'])->plainTextToken;
                    $success['name'] = $client->name;
                    $success['email'] = $client->email;
        
                    Auth::guard('client')->user()->tokens->each(function($token, $key) {
                        $expirationTime = now()->addMonths(1);
                        $token->expires_at = $expirationTime;
                        $token->save(); 
                    });
                    // echo "<pre>"; print_r(Auth::guard('client')->user()); die;
                    return response()->json([
                        'status' => 200,
                        "message" => "Client login successfully",
                        "data" => $success,
                    ]);
                }else{
                    return response()->json([
                        'status' => 401,
                        "message" => "Unauthorised check your email password",
                        "data" => "",
                    ]);
                }
            
        } else{ 
            return response()->json([
                'status' => 401,
                "message" => "Unauthorised check your email password",
                "data" => [],
            ]);
        } 
    }

    public function logout(Request $request): JsonResponse
    {
        // echo "<pre>"; print_r($request->user());
        $client = Auth::guard('sanctum')->user();
    //   echo "<pre>"; print_r($client); die;
            if(!empty($client)){
            Auth::guard('sanctum')->user()->tokens->each(function($token, $key) {
                $token->delete();
            });
        
            return response()->json([
                'status' => 200,
                'message' => 'Logged out successfully!'
            ], 200);
        }else{
            return response()->json([
                "status" => 401, 
                "message" => "Unauthenticated.",
                "data" => []
            ],401);
        }
    }

    public function uploadOwnerImage(Request $request ,$id)
    {
       
        $client = Client::find($id);
        // echo "<pre>"; print_r($request->file('image')); die;
        // echo "<pre>"; print_r($request->all()); die;
        if (!$client) {
          $userData =  $this->sendError('Validation Error.'); 
            $response = response()->json([
                'status'  =>   400,
                'message' => 'Invalid data send',
                'details' => $userData->messages(),
            ]);
        
            throw new HttpResponseException($response);  
        }
            $validator = Validator::make($request->all(), [
               'image' => 'required|image|mimes:jpeg,png,jpg|max:4096'
             ]);
        
        if($validator->fails()){
          
            $errors = $validator->errors();

            $response = response()->json([
                'status'  =>   400,
                'message' => 'Invalid data send',
                'details' => $errors->messages(),
            ]);
        
            throw new HttpResponseException($response);        
        }
  
        if ($request->file('image')) {
            $file = $request->file('image');
          $destinationPath =  public_path().'/uploads/client/';
          $file_name = time().rand(1,10000).".".$file->getClientOriginalExtension();
          $file->move($destinationPath,$file_name);
          $movedFile =  $file_name;
          $file_data= upload::create([
              'file'=>$movedFile,
          ]);
          Client::find($id)->fill([
            'owner_photo'=>$file_data->id,
        ])->save();
        $founds['image'] = url('/uploads/client/'.$file_name);
        return response()->json([
            'status' => 200,
            'message' => 'successfully!',
            "data" =>  $founds,
        ]);

      } else {
        return response()->json([
            "status" => 401, 
            "message" => "Invalid data send",
            "data" => []
        ]);
      } 

    }

    public function ChangePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' =>'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password',
        ]);
        
        if($validator->fails()){
            
            $errors = $validator->errors();
            
            $response = response()->json([
                'status'  =>   400,
                'message' => 'Invalid data send',
                'details' => $errors->messages(),
            ]);
            
            throw new HttpResponseException($response); 
        }
        // echo "<pre>"; print_r($request->all()); die;

        $user=$request->user();
        // echo "<pre>"; print_r($user); die;
        if (Hash::check($request->old_password,$user->password)) {
                 $user->update([
                    'password'=>Hash::make($request->new_password)
                  ]);
           return response()->json([
                 'status' => 200,
                 'message'=>'Password is change successfully',
              ]);
            }else{
               return response()->json([
                'status' => 400,
                'message'=>'Old password is not match',
               ]);
            }
    }

    public function update(Request $request)
    {
        // echo "<pre>"; print_r($request->all()); die;
        $validator = Validator::make(
            $request->all(),
            [
                    'name'=>'required',
                    'email'=>'required',
                    'owner_adharcard_number'=>'required|min:12',
                    'owner_phonenumber'=>'required',
                    // 'category_id'=>'required',
                    // 'outlet_name'=>'required',
                    // 'owner_adharcard_number'=>'required|min:12',
                    // 'opentime'=>'required',
                    // 'closetime'=>'required',
                    // 'outlet_address'=>'required',
                    // 'bank_name'=>'required',
                    // 'account_holder_name'=>'required',
                    // 'account_number'=>'required',
                    // 'ifsc_code'=>'required',
                    // 'longitude'=>'required',
                    // 'latitude'=>'required',
                    // 'owner_phonenumber'=>'required',
                    // 'city_id'=>'required',
            ],[
                'file_id.required' => 'Client Image field is required',
                'gumastaimg_id.required'=>'Gumasta Image field is required',
                'outlet_images_id.*'=>'Outlet Images field is required',
                'amenity_id.*'=>'Amenities field is required',
                'category_id'=>'Category field is required',
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
            $client_id = $request->user()->id;
            Client::find($client_id)->fill([
                'name'=>$request->name,
                'email'=>$request->email,
                'owner_adhar_card'=>$request->owner_adharcard_number,
                'owner_phonenumber'=>$request->owner_phonenumber,
                // 'username'=>$request->username,
                // 'outlet_name'=>$request->outlet_name,
                // 'outlet_address'=>$request->outlet_address,
                // 'owner_adhar_card'=>$request->owner_adharcard_number,
                // 'opentime'=>$request->opentime,
                // 'closetime'=>$request->closetime,
                // 'latitude'=>$request->latitude,
                // 'longitude'=>$request->longitude,
                // 'owner_phonenumber'=>$request->owner_phonenumber,
                // 'city'=>$request->city_id,
                // 'tax'=>$request->tax,
                // 'category_id'=>$request->category_id,
                //   'amenities_id'=>$request->amenities,
                 ])->save();

                //  Bank_detail::where('id', $request->user()->bank_details)->update([
                //     'acc_hold_name'=>$request->account_holder_name,
                //      'account_number'=>$request->account_number,
                //      'bank_name'=>$request->bank_name,
                //      'ifsc_code'=>$request->ifsc_code,
                //      ]);
           
                // echo "<pre>"; print_r($request->all());die;

                ClientAmenity::where('client_id',$client_id)->delete();

                $amenities = explode(',',$request->amenities); 
                // echo "<pre>"; print_r($amenities);die;
                foreach($amenities as $amenity){
                    ClientAmenity::create([
                        'amenities_id'=>$amenity,
                        'client_id'=>$client_id,
                        ]);     
                     }

                     return response()->json([
                        'status' => 200,
                        'message'=>'Profile is change successfully',
                        'data'=>[]
                     ]);

        }
    }
    
      public function updateOutletinfo(Request $request)
    {
      $validator = Validator::make(
            $request->all(),
            [
                'outlet_name'=>'required',
                'owner_phonenumber'=>'required',
                'outlet_address'=>'required',
                'category_id'=>'required',
                'opentime'=>'required',
                'closetime'=>'required',
                'state_id'=>'required',
                'city_id'=>'required',
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
            $client_id = $request->user()->id;
            Client::find($client_id)->fill([
                'outlet_name'=>$request->outlet_name,
                'outlet_address'=>$request->outlet_address,
                'opentime'=>$request->opentime,
                'closetime'=>$request->closetime,
                'owner_phonenumber'=>$request->owner_phonenumber,
                'state_id'=>$request->state_id,
                'city'=>$request->city_id,
                'category_id'=>$request->category_id,
                'amenities_id'=>$request->amenities,
                 ])->save();

                ClientAmenity::where('client_id',$client_id)->delete();

                $amenities = explode(',',$request->amenities); 
              
                foreach($amenities as $amenity){
                    ClientAmenity::create([
                        'amenities_id'=>$amenity,
                        'client_id'=>$client_id,
                        ]);     
                     }

                     return response()->json([
                        'status' => 200,
                        'message'=>'Profile is change successfully',
                        'data' => []
                     ]);

        }
 
    }
    
    public function gumastaimgupload(Request $request,$id)
    {
        $clients = Client::find($id);
        if (!$clients) {
            $clientData =  $this->sendError('Validation Error.'); 
            $response = response()->json([
                'status'  =>   400,
                'message' => 'Invalid data send',
                'details' => $clientData->messages(),
            ]);
            
            throw new HttpResponseException($response);  
        }
      
            $validator = Validator::make($request->all(), [
               'gumasta.*' => 'required',
               'gumasta' => 'required'
             ]);
          
        if($validator->fails()){
          
            $errors = $validator->errors();

            $response = response()->json([
                'status'  =>   400,
                'message' => 'Invalid data send',
                'details' => $errors->messages(),
            ]);
        
            throw new HttpResponseException($response);        
        }
  

        $movedFiles=$filedata=$file_id=$files=array();
                if($request->file('gumasta')){
                $type = $request->type;
                // $path = $type . '_path';
                $file_name = $request->gumasta;
                // $file_path = $request->$path;
                $file = $request->file('gumasta');
    
                $destinationPath = public_path().'/uploads/gumasta/';
                foreach($file as $value)
                {
                    $ext = $value->getClientOriginalExtension();
                    $file_name = time().rand(1,2000).".".$value->getClientOriginalExtension();
                    $value->move($destinationPath,$file_name);
                    $movedFiles[] =  $file_name;  

                }
                $file_id= array();
                 $found= array();
                foreach($movedFiles as $values)
                {
                      $filedata= Upload::create([
                            'file'=>$values,
                        ]);
                        $file_id[] = $filedata->id;
                        $found[] = url('/uploads/gumasta/'.$values); 
                    }
                    
                    // echo "<pre>"; print_r($oldIdarr); die;
                    $oldIdarray = implode(',',$file_id);
                    Client::find($id)->fill([
                        'gumasta'=>$oldIdarray,
                        ])->save();
                    
                    return response()->json([
                        'status' => 200,
                        'message' => 'successfully!',
                        'data' => $found
                    ]);

        }else {
            return response()->json([
                "status" => 401, 
                "message" => "File type not allowed",
                "data" => []
            ]);
          } 
        
    }
    
   
    
    public function outletimagesuploads(Request $request,$id)
    {
        $clients = Client::find($id);
        
        if (!$clients) {
            $clientData =  $this->sendError('Validation Error.'); 
            $response = response()->json([
                'status'  =>   400,
                'message' => 'Invalid data send',
                'details' => $clientData->messages(),
            ]);
            
            throw new HttpResponseException($response);  
        }
      
            $validator = Validator::make($request->all(), [
               'outlet_images.*' => 'required',
               'outlet_images' => 'required'
             ]);
          
        if($validator->fails()){
          
            $errors = $validator->errors();

            $response = response()->json([
                'status'  =>   400,
                'message' => 'Invalid data send',
                'details' => $errors->messages(),
            ]);
        
            throw new HttpResponseException($response);        
        }
  

        $movedFile=$file_data=$file_ids=$files=array();
                if($request->file('outlet_images')){
                $type = $request->type;
                // $path = $type . '_path';
                $file_name = $request->outlet_images;
                // $file_path = $request->$path;
                $file = $request->file('outlet_images');
    
                $destinationPath = public_path().'/uploads/client/';
                foreach($file as $value)
                {
                    $ext = $value->getClientOriginalExtension();
                    $file_name = time().rand(1,2000).".".$value->getClientOriginalExtension();
                    $value->move($destinationPath,$file_name);
                    $movedFile[] =  $file_name;  

                }
                $file_ids= array();
                 $found= array();
                foreach($movedFile as $values)
                {
                      $file_data= OutletImage::create([
                            'file'=>$values,
                        ]);
                        $file_ids[] = $file_data->id;
                         $found[] = url('/uploads/client/'.$values); 
                    }
                    
                    $oldIdarr = implode(',',$file_ids);
                    Client::find($id)->fill([
                     'outlet_images'=>$oldIdarr,
                         ])->save();
                    
                    return response()->json([
                        'status' => 200,
                        'message' => 'successfully!',
                        'data' => $found
                    ]);

        }else {
            return response()->json([
                "status" => 401, 
                "message" => "File type not allowed",
                "data" => []
            ]);
          } 

    }
    
    
    public function rentAgreement(Request $request,$id)
    {
        
        $clientagree = Client::find($id);
        if (!$clientagree) {
            $clientdata =  $this->sendError('Validation Error.'); 
            $response = response()->json([
                'status'  =>   400,
                'message' => 'Invalid data send',
                'details' => $clientdata->messages(),
            ]);
            
            throw new HttpResponseException($response);  
        }
      
            $validator = Validator::make($request->all(), [
               'rent_agreement.*' => 'required',
               'rent_agreement' => 'required'
             ]);
          
        if($validator->fails()){
            $errors = $validator->errors();
            $response = response()->json([
                'status'  =>   400,
                'message' => 'Invalid data send',
                'details' => $errors->messages(),
            ]);
        
            throw new HttpResponseException($response);        
        }
  
        $movedFile=$filedata=$file_ids=array();
                if($request->file('rent_agreement')){
                $type = $request->type;
                $file_name = $request->rent_agreement;
                $file = $request->file('rent_agreement');
    
                $destinationPath = public_path().'/uploads/agreement/';
                foreach($file as $value)
                {
                    $ext = $value->getClientOriginalExtension();
                    $file_name = time().rand(1,2000).".".$value->getClientOriginalExtension();
                    $value->move($destinationPath,$file_name);
                    $movedFile[] =  $file_name;  

                }

                $file_ids= array();
                $found =array();
                foreach($movedFile as $values)
                {
                    $filedata= Upload::create([
                        'file'=>$values,
                    ]);
                    $file_ids[] = $filedata->id;
                    $found[] = url('/uploads/agreement/'.$values); 
                }
          
                    $oldarray = implode(',',$file_ids);
                    Client::find($id)->fill([
                        'rent_agreement'=>$oldarray,
                        ])->save();

            
                    return response()->json([
                        'status' => 200,
                        'message' => 'successfully!',
                        'data' => $found
                    ]);

           }else {
            return response()->json([
                "status" => 401, 
                "message" => "File type not allowed",
                "data" => []
            ]);
          } 
        
    }
    
}
