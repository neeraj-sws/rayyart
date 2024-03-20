<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\Controller;
use App\Models\{Appointment};
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class ClientAppointmentController extends Controller
{
    public function getAppointment(Request $request)
    {
       $appointmentsData = Appointment::with('userData:id,name,email,mobile_number','appointmentDetail.clientServePriceData:id,price,services,client_id,category_id,sub_category_id','timeSlot:id,start_time,end_time')->where([ ['client_id', $request->user()->id], ['date', '>=',  Carbon::today()->toDateString()], ])->orderBy('id', 'desc')->get();

       $appointmentData = $appointmentsData->map(function ($appointment) {

                    // echo "<pre>"; print_r($appointment->toArray()); die;

                    return [
                        'id'=>$appointment->id,
                        'user_id'=>$appointment->user_id,
                        'client_id'=>$appointment->client_id,
                        'price'=>$appointment->price,
                        'sub_total'=>$appointment->sub_total,
                        'tax'=>$appointment->tax,
                        'date'=>$appointment->date,
                       'slot_id'=>$appointment->slot_id,
                       'user_data' =>$appointment->userData,
                       'appointment_detail'=>$appointment->appointmentDetail,
                       'time_slot'=>$appointment->timeSlot,
                    ];

       });

      
        return response()->json([
            'status' => 200,
            "message" => "Appointment List",
            "data" => $appointmentData->all(),
        ]); 
        //  echo "<pre>"; print_r($appointmentData->toArray()); die;
        
    }
     
    public function oldAppointment(Request $request)
      {
        $appointmentsdata = Appointment::with('userData:id,name,email,mobile_number','appointmentDetail.clientServePriceData:id,price,services,client_id,category_id,sub_category_id','timeSlot:id,start_time,end_time')->where([ ['client_id', $request->user()->id], ['date', '<',  Carbon::today()->toDateString()], ])->orderBy('id', 'desc')->get();
        
        $oldappointmentData = $appointmentsdata->map(function ($appointment) {
            // echo "<pre>"; print_r($appointment->toArray()); die;
            return [
                'id'=>$appointment->id,
                'user_id'=>$appointment->user_id,
                'client_id'=>$appointment->client_id,
                'price'=>$appointment->price,
                'sub_total'=>$appointment->sub_total,
                'tax'=>$appointment->tax,
                'date'=>$appointment->date,
               'slot_id'=>$appointment->slot_id,
               'user_data' =>$appointment->userData,
               'appointment_detail'=>$appointment->appointmentDetail,
               'time_slot'=>$appointment->timeSlot,
            ];
        });

        return response()->json([
            'status' => 200,
            "message" => "Old Appointment List",
            "data" => $oldappointmentData->all(),
        ]); 
    }

}