<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User,State,City,Favorite,Appointment, AppointmentDetaile};
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $route;

    protected $single_heading;
   public function __construct()
   {

    $this->route = new \stdClass;
    $this->single_heading = "Customer";
    $this->route->list = route('admin.customer.list');
    $this->route->add = route('admin.customer.add');
    $this->route->userStateData = route('admin.customer.userStateData');
    $this->route->store = route('admin.customer.store');
    $this->route->edit = route('admin.customer.edit',':id');
    $this->route->destory = route('admin.customer.destroy',':id');
    $this->route->customerFavorite = route('admin.customer.customerFavorite',':id');
    $this->route->customerAppointment = route('admin.customer.customerAppointment','');
    $this->route->customerAppointmentList = route('admin.customer.customerAppointmentList');
    $this->route->customerAppointmentDetails = route('admin.customer.customerAppointmentDetails');
   }

   public function index()
   {
    return view('admin.user.index',['single_heading'=>$this->single_heading, 'route'=> $this->route]);
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

      $qry = User::orderBy($columnName, $columnSortOrder)->where('name', 'LIKE', '%' . $searchValue . '%')->orWhere('email', 'LIKE', '%' . $searchValue . '%');
      $result = $qry->get();

      $totalRecordwithFilter = $totalRecords = $qry->count();
      $result = $qry->offset($row)->take($rowperpage)->get();
      $data = array();
      $i = 1;
        foreach ($result as $row) {
     
            $edit_url = $this->route->edit;
            $destroy = $this->route->destory;
            $action = '<div class="d-flex  order-actions">';
            $action .= '<a href="javascript:void(0);" onclick=edit_row("'.$edit_url.'",'.$row->id.');><i class="la-user-edit la"></i></a>';
            $action .= '&nbsp;&nbsp;<a href="javascript:void(0);"onclick=delete_row("'.$destroy.'",'.$row->id.')><i class="feather icon-trash-2"></i></a>';
            $action .= '</div>';
            $userFavorite = Favorite::where('user_id',$row->id)->get();
            $userAppoitment = Appointment::where('user_id',$row->id)->get();
            $userFavoriteCount= count($userFavorite);
            $userAppoitmentCount= count($userAppoitment);
            $city = City::where('id',$row->city_id)->first();

            $csfavoriteurl = $this->route->customerFavorite;
            $csappointList = $this->route->customerAppointment;

            $cusFavoriteBtn = '<button type="button" class="btn btn-outline-info btn-sm rounded" onclick=showfav("'.$csfavoriteurl.'",'.$row->id.');>'.$userFavoriteCount.'</button>';
            
            $appoitmentList = '<a class="btn btn-outline-info btn-sm rounded" href='.$csappointList.'/'.$row->id.'>'.$userAppoitmentCount.'</a>';
          
            $data[] = array(
                "id" => $i,
                "name"=>ucfirst($row->name),
                "email"=>$row->email,
                "city"=>@$city->name,
                "mobilenumber"=>$row->mobile_number,
                "favorite"=>$cusFavoriteBtn,
                "appointment"=>$appoitmentList,
                "action" => $action,
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

   public function add()
   {
        $states = State::where('status',1)->get();
        $cities = City::where('status',1)->get();
    return view('admin.user.add',['route'=>$this->route,'single_heading'=>$this->single_heading,'states'=>$states,'cities'=>$cities]);
   }

   public function userStateData(Request $request)
   {
    $cities = City::select('id','name','latitude','longitude')->where('state_id',$request->id)->get();
        // echo "<pre>"; print_r($cities->toArray()); die;
       
        $options =  "<option value=''>Select Cities ... </option>";
        foreach($cities as $city)
        {
            $options .="<option value='{$city->id}'>{$city->name}</option>";
        }
        return response()->json(['cities'=> $options]);
   }
   public function store(Request $request)
   {
    if($request->id){
            return $this->update($request);
    }else{
    $validator = Validator::make(
        $request->all(),
        [
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
            'address'=>'required',
            'longitude'=>'required',
            'latitude'=>'required',
            'number'=>'required',
        ]
    );
        if($validator->fails()){
            return response()->json(['status' => 0,'errors' =>  $validator->errors()]);
        }else{
            $info = User::create([
                'name'=> $request->name,
                'email'=> $request->email,
                'password'=>$request->password,
                'address'=> $request->address,
                'longitude'=>$request->longitude,
                'latitude'=>$request->latitude,
                'mobile_number'=>$request->number,
            ]);
            return response()->json(['status' => 1, 'message' => $this->single_heading .'saved successfully' ]);
        }
    }

   }

   public function edit($id)
   {
        $info = User::find($id);
        $cities = City::where('status',1)->where('state_id',$info->state_id)->get();
        $states = State::where('status',1)->get();
       return view('admin.user.edit',['info'=>$info,'route'=>$this->route,'single_heading'=>$this->single_heading,'cities'=>$cities,'states'=>$states]);
   }

   public function update(Request $request)
   {
      $validator = Validator::make(
        $request->all(),
        [
            'name'=>'required',
            'email'=>'required',
            'address'=>'required',
            'latitude'=>'required',
            'longitude'=>'required',
            'number'=>'required',
        ]
      );  
      
      if($validator->fails())
      {
        return response()->json(['status'=>0 ,'error'=>$validator->errors()]);
      }else{
        $info= User::find($request->id)->fill([
            'name'=> $request->name,
            'email'=> $request->email,
            'address'=> $request->address,
            'longitude'=>$request->longitude,
            'latitude'=>$request->latitude,
            'mobile_number'=>$request->number,
        ])->save();
        return response()->json(['status'=> 1 , 'message' => $this->single_heading .' updated successfully']);

      }
   }

   public function destroy($id)
   {
     $delt= User::destroy($id);
     return response()->json(['status'=>1, 'message' => $this->single_heading . ' deleted successfully']);
   }

   public function customerFavorite(Request $request)
   {
    $qry = Favorite::with(['clientFav:id,name,email,outlet_name,outlet_address,owner_phonenumber'])->where('user_id',$request->id)->groupBy('client_id');
      $results = $qry->get();
    //   echo "<pre>"; print_r($results->toArray()); die;
    return view('admin.user.customerFavoriteList',['single_heading'=>$this->single_heading, 'route'=> $this->route,'results'=>$results]);
   }

   public function customerAppointment(Request $request,$id)
   {
    return view('admin.user.customerAppointment',['single_heading'=>$this->single_heading, 'route'=> $this->route,'id'=>$id]);
   }

   public function customerAppointmentList(Request $request)
   {
        ## Read value
      $draw = $_POST['draw'];
      $row = $_POST['start'];
      $rowperpage = $_POST['length']; // Rows display per page
      $columnIndex = $_POST['order'][0]['column']; // Column index
      $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
      $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
      $searchValue = $_POST['search']['value']; // Search value

      $qry = Appointment::with(['clientData'=> function($q) use($searchValue){ $q->where('name', 'LIKE', '%' . $searchValue . '%'); },'timeSlot'])->orderBy($columnName, $columnSortOrder)->where('user_id',$request->id);
      $flterAppoit = $_POST['flterAppoitment'];
                if($flterAppoit == 0)
                {
                    $qry = $qry->where('date',date('Y-m-d'));
                }else if($flterAppoit == 1)
                {
                    $qry = $qry->where('date','<',date('Y-m-d'));
                }else if($flterAppoit == 2)
                {
                    $qry = $qry->where('date','>',date('Y-m-d'));
                }
      $result = $qry->get();
    // echo "<pre>"; print_r($result->toArray()); die;
      $totalRecordwithFilter = $totalRecords = $qry->count();
      $result = $qry->offset($row)->take($rowperpage)->get();
      $data = array();
      $i = 1;
        foreach ($result as $row) {
     
            $csappointmentlist = $this->route->customerAppointmentDetails;

            $cusFavoriteBtn = '<button type="button" class="btn btn-outline-info btn-sm rounded" onclick=showappointment("'.$csappointmentlist.'",'.$row->id.');>View</button>';
            $openTime = new DateTime($row->timeSlot->start_time);
            $startTime = $openTime->format("h:i A");
            $data[] = array(
                "id" => $i,
                "clientname"=>ucfirst(@$row->clientData->name),
                "email"=>@$row->clientData->email,
                "outlet_name"=>@$row->clientData->outlet_name,
                "mobilenumber"=>@$row->clientData->owner_phonenumber,
                "date"=>@$row->date,
                "starttime"=>@$startTime,
                "action"=>@$cusFavoriteBtn,
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

   public function customerAppointmentDetails(Request $request)
   {
        $appointment = Appointment::where('id',$request->id)->first();
        $appointmentDetails =  AppointmentDetaile::with(['clientServePriceData'])->where('appointments_id',$request->id)->get();
        // echo "<pre>"; print_r($appointmentDetails->toArray()); die;
        return view('admin.user.customerAppointmentDetails',['single_heading'=>$this->single_heading, 'route'=> $this->route,'appointment'=>$appointment,'appointmentDetails'=>$appointmentDetails]);
   }



}
