<?php
   
namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\{Appointment,OutletImage,AppointmentDetaile,Slot,Client,Holiday,SiteSetting};
use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends BaseController
{

    public function setAppointment(Request $request)
    {
        // Log::info('Log message with data:'); 
        $validate = Validator::make($request->all(),[
            'client_id'=>'required',
            'date'=>'required',
            'services'=>'required',
            'price'=>'required',
            
        ],[ 
            'client_id.required'=>'Client is required',
        ]);
        
        if($validate->fails()){
            $errors = $validate->errors();
            
            $response = response()->json([
                'status'  =>   400,
                'message' => 'Invalid data send',
                'details' => $errors->messages(),
            ]);
            
            throw new HttpResponseException($response);
        }else{
            
            $user = Auth::guard('sanctum')->user();
            $appointment = Appointment::create([
                'user_id'=>$user->id,
                'client_id'=>$request->client_id,
                'date'=>$request->date,
                'start_time'=>$request->start_time,
                'end_time'=>$request->end_time,
                'price'=>$request->price,
                'slot_id'=>$request->sloat_id,
                'sub_total'=>$request->sub_total,
                'tax'=>$request->tax,
            ]);
            
            $services =  explode(',',$request->services);
            foreach($services as $service){
                AppointmentDetaile::create([
                    'clientserviceprices_id' =>$service,
                    'appointments_id' =>$appointment->id,
                ]);
            }
            return response()->json([
                'status' => 200,
                "message" => "Add appointment successfully",
                ]);
        }
    }

    public function getAppointment()
    {
       $user = Auth::guard('sanctum')->user();

        $appointments = Appointment::with(['userData','timeSlot','clientData','appointmentDetail.clientServePriceData.CatId','appointmentDetail.clientServePriceData.subCate'])->where('user_id',$user->id)->orderBy('created_at', 'DESC')->get();
        //   echo "<pre>"; print_r($appointments->toArray()); die;
        $founds = $appointments->map(function ($appointment) {
            
                if(!empty($appointment->clientData->outlet_images)){
            $outlet_images_ids = explode(',', $appointment->clientData->outlet_images);
            $outletImages = OutletImage::select('file')
            ->where('id', $outlet_images_ids['0'])
            ->first();
                 $outletImages =  $outletImages->image_url;
                }else{
                   $outletImages ="";
                }
                 $openTime = new DateTime($appointment->timeSlot->start_time);
                $closeTime = new DateTime($appointment->timeSlot->end_time);
                $startTime = $openTime->format("h:i A");
                $endTime = $closeTime->format("h:i A");
                //   echo "<pre>"; print_r($appointment->appointmentDetail->toArray()); die;
            return [
               "id" => @$appointment->id,
                "user_id" => @$appointment->user_id,
                "client_id" => @$appointment->client_id,
                "price" => @$appointment->price,
                "sub_total" => @$appointment->sub_total,
                "tax" => @$appointment->tax,
                 "date" => @$appointment->date,
                "start_time" => @$startTime,
                "end_time" =>  @$endTime,
                "user_name" => @$appointment->userData->name,
                "user_email" => @$appointment->userData->email,
                "client_name"=>@$appointment->clientData->name,
                "client_email"=>@$appointment->clientData->email,
                "client_opentime"=>@$appointment->clientData->opentime,
                "client_closetime"=>@$appointment->clientData->closetime,
                "client_latitude"=>@$appointment->clientData->latitude,
                "client_longitude"=>@$appointment->clientData->longitude,
                "client_outlet_address"=>@$appointment->clientData->outlet_address,
                "client_outletImage"=>@ $outletImages,
                "client_outlet_name"=>@$appointment->clientData->outlet_name,
                "services"=>@$appointment->appointmentDetail,
                // 'slot'=>@$appointment->timeSlot,
            ];

        });
   
        return response()->json([
            'status' => 200,
            "data" => $founds,
            ]);
    }

    public function timesloat(Request $request)
    {
        $clientData =  Client::find($request->client_id);
        $user = Auth::guard('sanctum')->user();
        // echo $clientData->opentime;
        $reqDate = $request->date;
        $allTimes  = Slot::with(['appointSlot' => function($query) use($clientData,$reqDate,$user) { 
            $query->where('client_id',$clientData->id); $query->where('date',$reqDate); $query->where('user_id',$user->id);
        },'bookedSlot'=> function($query) use($clientData,$reqDate) { 
            $query->where('client_id',$clientData->id); $query->where('date',$reqDate); 
         } ])->where('start_time','>=',$clientData->opentime)->where('start_time','<=',$clientData->closetime)->get();
         
         $holidays = Holiday::where('client_id',$request->client_id)->get();
        //  echo "<pre>"; print_r($allTimes->toArray()); die;
        foreach($holidays as $holiday){

            if($holiday->date == $request->date){
                return response()->json([
                    'status' => 400,
                    "message" => "Today is holiday",
                    'data'=>[]
                    ]);
            }
        }
       
        $slotTime=[];
        $isBoo=$isDisabled="";
        foreach($allTimes as $alltime)
        {
            $openTime = new DateTime($alltime->start_time);
            $closeTime = new DateTime($alltime->end_time);
            $startTime = $openTime->format("h:i A");
            $endTime = $closeTime->format("h:i A");

            $indiaTime = Carbon::now('Asia/Kolkata');
            $formattedTime = $indiaTime->format("h:i A");
            $currentDate = $indiaTime->format("Y-m-d");
      
            $startTimeCarbon = Carbon::createFromFormat("h:i A", $startTime);
           $formattedTimeCarbon = Carbon::createFromFormat("h:i A", $formattedTime);


            if(!empty($alltime->appointSlot)){
                $isBook = 1;
            }else{
                $isBook = 0;
            }
            if($alltime->bookedSlot){
                $isDisabled = 1;
            }else if(($startTimeCarbon->lt($formattedTimeCarbon)) && ($request->date == $currentDate)){
                $isDisabled = 1;
            }else{
                $isDisabled = 0;
            }
      
            // echo date("h:i A");

            $slotTime[] = [
                'id' =>  $alltime->id,
                'start_time' =>$startTime,
                'end_time'=> $endTime,
                'is_book' => $isBook,
                'is_disabled'=> $isDisabled,
                        ];
        }
       

        return response()->json([
            'status' => 200,
            "data" => $slotTime,
            ]);
    }
    
    
        public function getServicesTax()
    {
        $taxAll = SiteSetting::get();
        return response()->json([
            'status' => 200,
            "data" => $taxAll,
            ]);

    }

}


?>