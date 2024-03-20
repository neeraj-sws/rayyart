<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\{User,SocialLogin,City};
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Mail\ForgotPasswordOtpMail;
use Illuminate\Support\Facades\Mail;

class AuthController extends BaseController
{

   
    public function register(Request $request): JsonResponse
    {
    //   Log::info('User data', ['userdata' => $request]);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address'=>'required',
            'mobile_number'=>'required|min:10',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password',
            'email' => 'required|email|unique:users', 
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
                $city = City::where('id',$request->city_id)->first();
                // echo "<pre>"; print_r($request->toArray()); die;
            $user = User::create([
                'name'=> $request->name,
                'email'=> $request->email,
                'password'=>bcrypt($request->password),
                'latitude'=> $request->latitude,
                'longitude'=> $request->longitude,
                'mobile_number'=>$request->mobile_number,
                'address'=> $request->address,
            ]);
            // $success['token'] = $user->createToken('MyApp')->plainTextToken;
            // $success['name'] = $user->name;
            
             $newToken = $user->createToken('MyApp');
            $success['token'] = $newToken->plainTextToken;
            $success['name'] = $user->name;

            $user->tokens->each(function($token, $key) {
                    $expirationTime = now()->addMonths(1);
                    $token->expires_at = $expirationTime;
                    $token->save(); 
                });
                
            return response()->json([
                'status' => 200,
                'message' => 'User registered successfully',
                'data' => $success,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 400, 
                'message' => 'User with this email already exists',
                'data' => "",
            ]);
        }
    }

    public function login(Request $request): JsonResponse
    {
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

        if(Auth::guard('web')->attempt(['email' => $request->email, 'password' =>  $request->password])){ 
            
            $user = Auth::guard('web')->user(); 
            $success['token'] = $user->createToken('MyApp',['user'])->plainTextToken;
            $success['name'] = $user->name;
            $success['email'] = $user->email;
            
            //  echo "<pre>"; print_r($success); die;
            // $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
            // $success['name'] =  $user->name;
            // $success['email'] =  $user->email;
            Auth::guard('web')->user()->tokens->each(function($token, $key) {
                $expirationTime = now()->addHours(2);
                $token->expires_at = $expirationTime;
                $token->save(); 
            });
          
            return response()->json([
                'status' => 200,
                "message" => "User login successfully",
                "data" => $success,
            ]);

        }else{ 
            return response()->json([
                'status' => 401,
                "message" => "Unauthorised check your email password",
                "data" => "",
            ]);
        } 
    }

    function ChangePassword(Request $request) 
    { 
        $validator = Validator::make($request->all(), [
            'old_password' =>'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
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

        $user=$request->user();

        if (Hash::check($request->old_password,$user->password)) {
                 $user->update([
                    'password'=>Hash::make($request->password)
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

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => ['required',
            Rule::unique('users')->ignore($id),
            'email',
        ],
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

        $auth = User::find($id);
        if (!$auth) {
            return response()->json([
                'status'  =>   400,
                'message' => 'comman not found'
            ]); 
        }

        $input = $request->all();
       $sub['name'] =  $auth->name = $request->input('name');
       $sub['email']  =  $auth->email = $request->input('email');
       $sub['mobile_number']  =  $auth->mobile_number = $request->input('mobile_number');
       
        $updated = $auth->update();

        if ($updated) {
            return response()->json([
                'status' => 200,
                'message' => 'successfully!',
                "data" =>  $sub,
            ]);
        } else {
            return response()->json([
                "status" => 401, 
                "message" => "Unauthenticated.",
                "data" => ""
            ]);
        }
    }

    public function update_image(Request $request, $id)
    {
     
        $found = User::find($id);
        
        if (!$found) {
          $userData =  $this->sendError('Validation Error.'); 
            $response = response()->json([
                'status'  =>   400,
                'message' => 'Invalid data send',
                'details' => $userData->messages(),
            ]);
        
            throw new HttpResponseException($response);  
        }
        $validator = Validator::make($request->all(), [
          'image' => 'required'
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
  
        if ($request->hasFile('image')) {
          $destinationPath =  public_path().'/uploads/user/';
          $filess = $request->image;
          $fileNames = time() . '.' . $filess->getClientOriginalName(); 
          $filess->move($destinationPath, $fileNames);
          $found['image'] =  $fileNames;
      } else {
          $input['image'] = null;
      } 
  
        $found->update($request->except('image'));
         $founds['image'] = url('/uploads/user/'.$fileNames);
 
 
        if ($founds) {
            return response()->json([
                'status' => 200,
                'message' => 'successfully!',
                "data" =>  $founds,
            ]);
        } else {
            return response()->json([
                "status" => 401, 
                "message" => "Unauthenticated.",
                "data" => ""
            ]);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try{
            Auth::user()->tokens->each(function($token, $key) {
                $token->delete();
            });
        
            return response()->json([
                'status' => 200,
                'message' => 'Logged out successfully!'
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                "status" => 401, 
                "message" => "Unauthenticated.",
                "data" => ""
            ]);
        }
    }

    public function createOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' =>'required',
        ]);
   
        if($validator->fails()){
            
            $errors = $validator->errors();

            $response = response()->json([
                'status'  =>   400,
                'message' => 'Invalid data send',
                'details' => $errors->messages(),
            ]);
        
            throw new HttpResponseException($response); 
        }else{
           $user = User::where('email',$request->email)->first();

                if(empty($user)){

                            return response()->json([
                                "status" => 401, 
                                "message" => "Invalid data send.",
                            ]);

                }else{
                       
                    $OTP = rand(1000,9999);
                    $otpExpirationTime = now()->addMinutes(2);
                    $data = date("Y-m-d H:i:s");
                    User::where('email',$request->email)->update(['otp'=>$OTP,'expire_otp_at'=> $otpExpirationTime]);
                
                    $mailData = [
                        'otp'  => $OTP,
                        'user' => $user,
                     ];
                   
                    Mail::to($user->email)->send(new ForgotPasswordOtpMail($mailData));
                    return response()->json([
                        "status" => 200, 
                        "message" => "Email send successfully.",
                        'opt' =>$OTP,
                        'expire_otp'=>$otpExpirationTime,
                    ]);
                }
           
        }
    }


    public function submitOTP(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'otp'=> 'required',
            'password' =>'required',
            'confirm_password' =>'required|same:password'
        ]);
   
        if($validator->fails()){
            
            $errors = $validator->errors();

            $response = response()->json([
                'status'  =>   400,
                'message' => 'Invalid data send',
                'details' => $errors->messages(),
            ]);
        
            throw new HttpResponseException($response); 
        }else{
            $data = date("Y-m-d H:i:s");
           $user = User::where('otp',$request->otp)->first();
            if(empty($user)){
                return response()->json([
                    'status'  =>   400,
                    'message' => 'Invalid OTP send',
                ]);
            }else if(now()->lessThanOrEqualTo($user->expire_otp_at)){

                User::where('otp',$request->otp)->update(['password'=>Hash::make($request->password)]);
                return response()->json([
                    "status" => 200, 
                    "message" => "password change successfully.",
                ]);

            }else{
              return response()->json([
                    'status'  =>   400,
                    'message' => 'OTP expired',
                ]);
            }
          
        }
    }

   public function socialLogin(Request $request)
    {      
        
        file_put_contents('login_logs.txt', 'Cn_social_login-'.$request.PHP_EOL , FILE_APPEND | LOCK_EX);

        $social_id = $request->id;   
        $firstname =$request->firstname.' '.$request->lastname; 
        $email = $request->email; 
        $social_type = $request->provider;   
        $address = $request->address;   
        $latitude = $request->latitude;   
        $longitude = $request->longitude;   
    
    
        // $lastname = $request->lastname;   

    //   echo $firstname ;die;
// echo "<pre>"; print_r($email); die;
    $userData = User::where('email',$email)->first();

    if(!empty($userData)){
            $user = $userData; 
            $newToken = $user->createToken('MyApp');
            $success['token'] = $newToken->plainTextToken;
            $success['name'] = $user->name;
            $success['email'] = $user->email;

            User::where('email',$email)->update(
                [
                    'social_id'=> $request->social_id,
                    'social_type'=> $request->social_type,
                    'address'=> $request->address,
                    'latitude'=> $request->latitude,
                    'longitude'=> $request->longitude
                ]);
            
            $userData->tokens->each(function($token, $key) {
                $expirationTime = now()->addMonths(1);
                $token->expires_at = $expirationTime;
                $token->save(); 
            });
        
            return response()->json([
                'status' => 200,
                "message" => "User login successfully",
                "data" => $success,
            ]);

    } else{
        $user = User::create([
            'email'=> $request->email,
            'name'=> $request->firstname,
            'social_id'=> $request->social_id,
            'social_type'=> $request->social_type,
            'address'=> $request->address,
            'latitude'=> $request->latitude,
            'longitude'=> $request->longitude,
        ]);
        // $success['token'] = $user->createToken('MyApp')->plainTextToken;
        // $success['name'] = $user->name;
        
         $newToken = $user->createToken('MyApp');
        $success['token'] = $newToken->plainTextToken;
        $success['name'] = $user->name;
        

        $user->tokens->each(function($token, $key) {
                $expirationTime = now()->addMonths(1);
                $token->expires_at = $expirationTime;
                $token->save(); 
            });
            
        return response()->json([
            'status' => 200,
            'message' => 'User registered successfully',
            'data' => $success,
        ]);
    }
         
    }

    
}
