<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User,State,City,Favorite,Appointment, AppointmentDetaile};
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;


class AppointmentController extends Controller
{
    protected $route;

    protected $single_heading;
   public function __construct()
   {

    $this->route = new \stdClass;
    $this->single_heading = "Appointments";
    $this->route->list = route('admin.appointment.list');
    $this->route->details = route('admin.appointment.details',':id');
    $this->route->invoice = route('admin.appointment.invoice','');

   }

   public function index()
   {
    return view('admin.appointment.index',['single_heading'=>$this->single_heading, 'route'=> $this->route]);
   }

   public function list(Request $request)
   {
      ## Read value
      $draw = $_POST['draw'];
      $row = $_POST['start'];
      $rowperpage = $_POST['length']; // Rows display per page
      $columnIndex = $_POST['order'][0]['column']; // Column index
      $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
      $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
      $searchValue = $_POST['search']['value']; // Search value

      $qry = Appointment::with(['userData:id,name,email,mobile_number','clientData:id,name,email,outlet_name,owner_phonenumber','timeSlot']);
      
      if(!empty($searchValue)){
       $qry = $qry->whereHas('userData',function(Builder $query) use($searchValue) { $query->where('users.name', 'like', '%'.$searchValue.'%');});
      }
      $result = $qry->get();
    //   echo "<pre>"; print_r($result->toArray()); die;
      $totalRecordwithFilter = $totalRecords = $qry->count();
      $result = $qry->offset($row)->take($rowperpage)->get();
      $data = array();
      $i = 1;
        foreach ($result as $row) {
            $openTime = new DateTime($row->timeSlot->start_time);
                    $time= $openTime->format("h:i A");

                        $details = $this->route->details;
                        $invoice = $this->route->invoice;
                    $details = '<button type="button" class="btn btn-outline-info btn-sm rounded" onclick=details("'.$details.'",'.$row->id.')>Details</button>';
                                
                    $invoice = '<a class="btn btn-outline-info btn-sm rounded" href="'.$invoice.'/'.$row->id.'">Invoice</a>';
            $data[] = array(
                "id" => $i,
                "customer"=>'Name:- '.ucfirst($row->userData->name).'<br>'.'Email:- '.$row->userData->email.'<br>'.'Mobile:- '.$row->userData->mobile_number,
                "client"=>'Name:- '.@$row->clientData->name.'<br>'.'Email:- '.@$row->clientData->email.'<br>'.'Mobile:- '.@$row->clientData->owner_phonenumber.'<br>'.'Outlet Name:- '.@$row->clientData->outlet_name,
                "date"=>$row->date,
                "time"=>$time,
                "price"=>'₹ '.$row->price,
                "invoice"=>$invoice,
                "details"=>$details,
            );

            $i++;
        }

                ## Response
                $response = array(
                    "draw" => intval($draw),
                    "iTotalRecords" => $totalRecords,
                    "iTotalDisplayRecords" => $totalRecordwithFilter,
                    "aaData" => $data
                );
        
                echo json_encode($response);
   }

   public function details(Request $request,$id)
   {
        $appointmet = Appointment::with(['userData:id,name,email,mobile_number','clientData:id,name,email,outlet_name,owner_phonenumber,outlet_address','timeSlot'])->where('id',$id)->first();
                // echo "<pre>"; print_r($appointmet->toArray());
        $appointmentDetails = AppointmentDetaile::with(['clientServePriceData'])->where('appointments_id',$id)->get();

        return view('admin.appointment.appointmentDetails',['single_heading'=>$this->single_heading, 'route'=> $this->route,'appointment'=> $appointmet,'appointmentDetails'=>$appointmentDetails]);
      
   }

   public function invoice(Request $request,$id)
   {
    $appointmet = Appointment::with(['userData:id,name,email,mobile_number','clientData:id,name,email,outlet_name,owner_phonenumber,outlet_address','timeSlot'])->where('id',$id)->first();
    // echo "<pre>"; print_r($appointmet->toArray());
$appointmentDetails = AppointmentDetaile::with(['clientServePriceData'])->where('appointments_id',$id)->get();

return view('admin.appointment.invoice',['single_heading'=>$this->single_heading, 'route'=> $this->route,'appointment'=> $appointmet,'appointmentDetails'=>$appointmentDetails]);
   }


}