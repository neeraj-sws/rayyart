<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\{Client,Category, ClientServicePrice, Services,SubCategory,Upload,Bank_detail,OutletImage,Amenity,City,ClientAmenity, Holiday,Slot, SlotAvailability,State,Appointment,AppointmentDetaile};
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class ClientController extends Controller
{
    protected $route;

    protected $single_heading;

    public function __construct()
    {
        $this->route = new \stdClass;
        $this->single_heading = "Client";
        $this->route->list = route('admin.client.list');
        $this->route->inactive = route('admin.client.inactive');
        $this->route->add = route('admin.client.add');
        $this->route->store = route('admin.client.store');
        $this->route->status = route('admin.client.status');
        $this->route->edit = route('admin.client.edit','');
        $this->route->destroy = route('admin.client.destroy',':id');
        $this->route->addservices =route('admin.client.services',':id');
        $this->route->storeservices = route('admin.client.storecservices');
        $this->route->clientServicesList = route('admin.client.clientServicesList');
        $this->route->clientServicesEdit = route('admin.client.clientServicesEdit',':id');
        $this->route->clientServicesUpdate = route('admin.client.clientServicesUpdate');
        $this->route->clientServicesDestory = route('admin.client.clientServicesDestory',':id');
        $this->route->saveimage = route('admin.client.saveimage');
        $this->route->gumastaimgupload = route('admin.client.gumastaimgupload');
        
        $this->route->agreementimgupload = route('admin.client.agreementimgupload');
        
        $this->route->outletimagesupload = route('admin.client.outletimagesupload');
        $this->route->multipleimagedelete = route('admin.client.multipleimagedelete');
        $this->route->clientdetails = route('admin.client.clientdetails','');
        $this->route->clientamenitiesdetails = route('admin.client.clientamenitiesdetails');
        $this->route->clientprofiledetails = route('admin.client.clientprofiledetails');
        $this->route->clientservicesdetails = route('admin.client.clientservicesdetails');
        $this->route->clientAppointment = route('admin.client.clientAppointment');
        $this->route->clientAppointmentList = route('admin.client.clientAppointmentList');
        $this->route->clientAppointmentListDetails = route('admin.client.clientAppointmentListDetails');
        $this->route->clientupdateprofiledetails = route('admin.client.clientupdateprofiledetails');
        $this->route->clientupdateprofiledata = route('admin.client.clientupdateprofiledata');
        $this->route->clientprofiledetail = route('admin.client.clientprofiledetail');
        $this->route->addholiday = route('admin.client.holiday',':id');
        $this->route->holidaylist = route('admin.client.holidaylist');
        $this->route->storeholiday = route('admin.client.storeholiday');
        $this->route->editholiday = route('admin.client.editholiday',':id');
        $this->route->updateholiday = route('admin.client.updateholiday');
        $this->route->holidayDestory = route('admin.client.hlidaydestroy',':id');
        $this->route->slot = route('admin.client.slot',':id');
        $this->route->availabilityslot = route('admin.client.availability');
        $this->route->slotWithDate = route('admin.client.slotWithDate');
        
        $this->route->getClientData = route('admin.client.getclientdata',':id');
        $this->route->getStateData = route('admin.client.getStateData');
    }


public function getClientData(Request $request)
{
    $client = Client::find($request->id);
    $category = Category::find($client->category_id);
    $cities = City::find($client->city);
       
        $services = ClientServicePrice::select('services', DB::raw('COUNT(*) as count'))
            ->where('category_id', $category->id)
            ->where('client_id', $client->id)
            ->groupBy('services')
            ->get();
        
        $options = '';
        
        foreach ($services as $service) { 
            
            $options .= "<option value='{$service->services}'>{$service->services}</option>";
        }
        
        $html = "<option value='{$category->id}'>{$category->title}</option>";
         $city = "<option value='{$cities->id}'>{$cities->name}</option>";
        
        return response()->json(['category' => $html, 'services' => $options, 'city'=> $city]);

}
    public function getStateData(Request $request)
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


    public function index()
    {
          $category = Category::where('status',1)->get();
        
         $clients = Client::get()->toArray();
          $column = array_column($clients, 'city');
         
         $cities = City::where('status',1)->whereIn('id',$column)->get();
          $services = ClientServicePrice::select('services', DB::raw('COUNT(*) as count'))
            ->groupBy('services')
            ->get();
        $usernames = Client::get();
        return view('admin.client.index',['single_heading' => $this->single_heading,'route'=> $this->route,'categories'=> $category,'usernames'=>$usernames,'services'=>$services,'cities'=>$cities]);
    }
    
     public function inactiveList()
    {  
        $single_heading = 'InavtiveClient';
          $category = Category::where('status',1)->get();
        
         $clients = Client::get()->toArray();
          $column = array_column($clients, 'city');
         
         $cities = City::where('status',1)->whereIn('id',$column)->get();
          $services = ClientServicePrice::select('services', DB::raw('COUNT(*) as count'))
            ->groupBy('services')
            ->get();
        $usernames = Client::get();
        return view('admin.client.inactive_client',['single_heading' => $this->single_heading,'route'=> $this->route,'categories'=> $category,'usernames'=>$usernames,'services'=>$services,'cities'=>$cities]);
    }

    public function list()
    {
        //  echo "<pre>"; print_r($_POST['service']);
        $draw = $_POST['draw'];
      $row = $_POST['start'];
      $rowperpage = $_POST['length']; 
      $columnIndex = $_POST['order'][0]['column']; 
      $columnName = $_POST['columns'][$columnIndex]['data']; 
      $columnSortOrder = $_POST['order'][0]['dir']; 
      $searchValue = $_POST['search']['value']; 
      $category = $_POST['category']; 
       $city = $_POST['city'];
      $username =$_POST['username'];
      $services=$_POST['service'];
      $qry = Client::orderBy($columnName, $columnSortOrder)->where('status',1);
      if(!empty($searchValue)){
        $qry = Client::where('name', 'LIKE', '%' . $searchValue . '%') ->orWhere('email', 'LIKE', '%' . $searchValue . '%')->orWhere('username', 'LIKE', '%' . $searchValue . '%');
      } 

      if(!empty($services)){ 
        
    $qry = Client::with('servicePrice')->whereHas('servicePrice', function($query) use ($services) {
        return $query->where('services',$services);
    });

      }
    
      if(!empty($category)){
      $qry = $qry->Where('category_id',$category);
        }  
        
        if(!empty($city)){ 
      $qry = $qry->Where('city',$city);
        } 
           
    if(!empty($username)){
        $qry = $qry->Where('id',$username);
         }

      $result = $qry->get();
     

      $totalRecordwithFilter = $totalRecords = $qry->count();
      $result = $qry->offset($row)->take($rowperpage)->get();
      $data = array();
      $i = 1;
        foreach ($result as $row) {
     
            $edit_url = $this->route->edit;
            $destroy = $this->route->destroy;
            $action = '<div class="d-flex  order-actions">';
            $action .= '<a href="'.$edit_url.'/'.$row->id.'"><i class="la-user-edit la"></i></a>';
            $action .= '&nbsp;&nbsp;<a href="javascript:void(0);"onclick=delete_row("'.$destroy.'",'.$row->id.')><i class="feather icon-trash-2"></i></a>';
            $action .= '</div>';
                $addservice_url = $this->route->addservices;
                $clientServprice = ClientServicePrice::where('client_id',$row->id)->get();
                $holidayCount = Holiday::where('client_id',$row->id)->count();
                $clientServpriceCount= count($clientServprice);
                $status_url = $this->route->status;
                if($row->status == 1){
                    $status = '<a href="javascript:void(0);" class="d-flex align-items-center text-success"  onclick=status_change("'.$status_url.'",0,'.$row->id.');><span class="badge-dot me-2 bg-success"></span><span class="text-capitalize">active</span></a>';
                }else{
                    $status = '<a href="javascript:void(0);" class="d-flex align-items-center text-danger" checked="" onclick=status_change("'.$status_url.'",1,'.$row->id.');><span class="badge-dot me-2 bg-danger"></span><span class="text-capitalize">Inactive</span></a>';
                }
            if($clientServpriceCount > 0){
                $service = '<button type="button" class="btn btn-outline-info btn-sm rounded" onclick=addservices("'.$addservice_url.'",'.$row->id.')>'.$clientServpriceCount.'</button>';
            }else{
                $service = '<button type="button" class="btn btn-outline-info btn-sm rounded" onclick=addservices("'.$addservice_url.'",'.$row->id.')>Add</button>';
            }
                        $addholidaysURL= $this->route->addholiday;
            if($holidayCount > 0){
                $holidays = '<button type="button" class="btn btn-outline-info btn-sm rounded" onclick=addholidays("'.$addholidaysURL.'",'.$row->id.')>'.$holidayCount.'</button>';
            }else{
                $holidays = '<button type="button" class="btn btn-outline-info btn-sm rounded" onclick=addholidays("'.$addholidaysURL.'",'.$row->id.')>Add</button>';
            }
                      $addslatURL= $this->route->slot;
            $slotlink = '<button type="button" class="btn btn-outline-info btn-sm rounded" onclick=addslot("'.$addslatURL.'",'.$row->id.')>Slot</button>';

            $detailurl = $this->route->clientdetails;
            $clientdetails = '<a href="'.$detailurl.'/'.$row->id.'" class="btn btn-primary btn-sm rounded"><i class="bx bxs-plus-square"></i> Detail</a>';

            $data[] = array(
                "sno" => $i,
                "name"=> ucfirst($row->name),
                "email"=>$row->email,
                "cities"=> ucfirst(@$row->CityId->name),
                "category"=>ucfirst(@$row->CatId->title),
                "services"=>$service,
                "holidays"=>$holidays,
                "slot"=>$slotlink,
                "outlet name"=>$row->outlet_name,
                "status"=>$status,
                "detail"=>$clientdetails,
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
    
    
    public function inactive_list(Request $request)
    {  //echo "<pre>"; print_r($request->all());die;
        //  echo "<pre>"; print_r($_POST['service']);
      $draw = $_POST['draw'];
      $row = $_POST['start'];
      $rowperpage = $_POST['length']; 
      $columnIndex = $_POST['order'][0]['column']; 
      $columnName = $_POST['columns'][$columnIndex]['data']; 
      $columnSortOrder = $_POST['order'][0]['dir']; 
      $searchValue = $_POST['search']['value']; 
      $category = $_POST['category']; 
       $city = $_POST['city'];
      $username =$_POST['username'];
      $services=$_POST['service'];
      $qry = Client::orderBy($columnName, $columnSortOrder)->where('status',0);
      if(!empty($searchValue)){
        $qry = Client::where('name', 'LIKE', '%' . $searchValue . '%') ->orWhere('email', 'LIKE', '%' . $searchValue . '%')->orWhere('username', 'LIKE', '%' . $searchValue . '%');
      } 

      if(!empty($services)){ 
        
    $qry = Client::with('servicePrice')->whereHas('servicePrice', function($query) use ($services) {
        return $query->where('services',$services);
    });

      }
    
      if(!empty($category)){
      $qry = $qry->Where('category_id',$category);
        }  
        
        if(!empty($city)){ 
      $qry = $qry->Where('city',$city);
        } 
           
    if(!empty($username)){
        $qry = $qry->Where('id',$username);
         }

      $result = $qry->get();
     

      $totalRecordwithFilter = $totalRecords = $qry->count();
      $result = $qry->offset($row)->take($rowperpage)->get();
      $data = array();
      $i = 1;
        foreach ($result as $row) {
     
            $edit_url = $this->route->edit;
            $destroy = $this->route->destroy;
            $action = '<div class="d-flex  order-actions">';
            $action .= '<a href="'.$edit_url.'/'.$row->id.'"><i class="la-user-edit la"></i></a>';
            $action .= '&nbsp;&nbsp;<a href="javascript:void(0);"onclick=delete_row("'.$destroy.'",'.$row->id.')><i class="feather icon-trash-2"></i></a>';
            $action .= '</div>';
                $addservice_url = $this->route->addservices;
                $clientServprice = ClientServicePrice::where('client_id',$row->id)->get();
                $holidayCount = Holiday::where('client_id',$row->id)->count();
                $clientServpriceCount= count($clientServprice);
                $status_url = $this->route->status;
                if($row->status == 1){
                    $status = '<a href="javascript:void(0);" class="d-flex align-items-center text-success"  onclick=status_change("'.$status_url.'",0,'.$row->id.');><span class="badge-dot me-2 bg-success"></span><span class="text-capitalize">active</span></a>';
                }else{
                    $status = '<a href="javascript:void(0);" class="d-flex align-items-center text-danger" checked="" onclick=status_change("'.$status_url.'",1,'.$row->id.');><span class="badge-dot me-2 bg-danger"></span><span class="text-capitalize">Inactive</span></a>';
                }
            if($clientServpriceCount > 0){
                $service = '<button type="button" class="btn btn-outline-info btn-sm rounded" onclick=addservices("'.$addservice_url.'",'.$row->id.')>'.$clientServpriceCount.'</button>';
            }else{
                $service = '<button type="button" class="btn btn-outline-info btn-sm rounded" onclick=addservices("'.$addservice_url.'",'.$row->id.')>Add</button>';
            }
                        $addholidaysURL= $this->route->addholiday;
            if($holidayCount > 0){
                $holidays = '<button type="button" class="btn btn-outline-info btn-sm rounded" onclick=addholidays("'.$addholidaysURL.'",'.$row->id.')>'.$holidayCount.'</button>';
            }else{
                $holidays = '<button type="button" class="btn btn-outline-info btn-sm rounded" onclick=addholidays("'.$addholidaysURL.'",'.$row->id.')>Add</button>';
            }
                      $addslatURL= $this->route->slot;
            $slotlink = '<button type="button" class="btn btn-outline-info btn-sm rounded" onclick=addslot("'.$addslatURL.'",'.$row->id.')>Slot</button>';

            $detailurl = $this->route->clientdetails;
            $clientdetails = '<a href="'.$detailurl.'/'.$row->id.'" class="btn btn-primary btn-sm rounded"><i class="bx bxs-plus-square"></i> Detail</a>';

            $data[] = array(
                "sno" => $i,
                "name"=> ucfirst($row->name),
                "email"=>$row->email,
                "cities"=> ucfirst(@$row->CityId->name),
                "category"=>ucfirst(@$row->CatId->title),
                "services"=>$service,
                "holidays"=>$holidays,
                "slot"=>$slotlink,
                "outlet name"=>$row->outlet_name,
                "status"=>$status,
                "detail"=>$clientdetails,
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
        $category = Category::where('status',1)->get();
        $amenities = Amenity::where('status',1)->get();
        $times = Slot::get();
        $startTime=$endTime=[];
        foreach($times as $time)
        {
             $openTime = new DateTime($time->start_time);
            $closeTime = new DateTime($time->end_time);
                
            
               $startTime[$time->start_time] = $openTime->format("h:i A");
               $endTime[$time->end_time] = $closeTime->format("h:i A");
               
        }

        $cities = City::where('status',1)->get();
        $states = State::where('status',1)->get();
        //  echo "<pre>"; print_r($endTime); die;
        return view('admin.client.add',['route'=>$this->route , 'single_heading'=>$this->single_heading,'categories'=>$category,'amenities'=>$amenities,'cities'=>$cities,'startTime'=>$startTime,'endTime'=>$endTime,'states'=>$states]);
    }

    public function store(Request $request)
    {
    //   echo "<pre>"; print_r($request->toArray()); die; 
                if($request->id){
                    return $this->update($request);
                }else{
            $validator = Validator::make(
                $request->all(),
                [
                    'name'=>'required',
                    'email'=>'required',
                    'username'=>'required',
                    'category_id'=>'required',
                    'password'=>'required|min:6',
                    'outlet_name'=>'required',
                    'ownerAdharCard'=>'required|min:12',
                    'opentime'=>'required',
                    'closetime'=>'required',
                    'file_id'=>'required',
                    'outletAddress'=>'required',
                    // 'bankName'=>'required',
                    // 'accountHolderName'=>'required',
                    // 'accountNumber'=>'required|min:8',
                    // 'ifscCode'=>'required',
                    'gumasta_images_id.*'=>'required',
                    'outlet_images_id.*'=>'required',
                    'amenity_id.*'=>'required',
                    'logitude'=>'required',
                    'latitude'=>'required',
                    'phoneNumber'=>'required',
                    'city'=>'required',
                    'state'=>'required',

                ],[
                    'file_id.required' => 'Client Image field is required',
                    'gumasta_images_id.*'=>'Gumasta Image field is required',
                    'outlet_images_id.*'=>'Outlet Images field is required',
                    'amenity_id.*'=>'Amenities field is required',
                    'category_id'=> 'Category field is required',
                ]
            );
                if($validator->fails()){
                    return response()->json(['status' => 0,'errors' =>  $validator->errors()]);
                }else{
                    $images = $request->outlet_images_id;
                    $category = $request->category_id;
                    $multipleImages = implode(',',$images);
                    
                     $image = $request->gumasta_images_id;
                    $gumastaImages = implode(',',$image);

                   // echo "<pre>"; print_r($request->toArray()); die;
                    $info = Client::create([
                        'name'=>$request->name,
                        'email'=>$request->email,
                        'username'=>$request->username,
                        'category_id'=>$category,
                        'password'=>$request->password,
                        'outlet_name'=>$request->outlet_name,
                        'owner_adhar_card'=>$request->ownerAdharCard,
                        'opentime'=>$request->opentime,
                        'closetime'=>$request->closetime,
                        'owner_photo'=>$request->file_id,
                        'outlet_address'=>$request->outletAddress,
                        'gumasta'=>$gumastaImages,
                        'outlet_images'=>$multipleImages,
                        'latitude'=>$request->latitude,
                        'longitude'=>$request->logitude,
                        'owner_phonenumber'=>$request->phoneNumber,
                        'city'=>$request->city,
                        'tax'=>$request->tax,
                        'state_id'=>$request->state,
                        
                    ]);
                    
                    // $accInfo = Bank_detail::create([
                    //     'acc_hold_name'=>$request->accountHolderName,
                    //     'account_number'=>$request->accountNumber,
                    //     'bank_name'=>$request->bankName,
                    //     'ifsc_code'=>$request->ifscCode,
                    //     'client_id'=>$info->id,
                    // ]);
                    // $updatInfo= Client::find($info->id)->fill(['bank_details'=>$accInfo->id])->save();
                    
                    $amenities = $request->amenity_id; 
                foreach($amenities as $amenity){
                          ClientAmenity::create([
                            'amenities_id'=>$amenity,
                            'client_id'=>$info->id,
                            ]);      
                     }
                $amenityId = implode(',',$amenities);
                Client::find($info->id)->fill([
                            'amenities_id'=>$amenityId,
                       ])->save();

                 return response()->json(['status' => 1, 'message' => $this->single_heading .'saved successfully' ]);
                }
            }
    }

    public function edit($id)  
    {
            $info = Client::find($id);
            // echo "<pre>"; print_r($info); die;
            $category = Category::get();    
            // $bankDetails = Bank_detail::where('client_id',$id)->first();
            $cities = City::where('status',1)->where('state_id',$info->state_id)->get();
            $states = State::where('status',1)->get();
            $strimages = $info->outlet_images;
            $amenitys= $info->amenities_id;
            $categorys= $info->category_id;
             $gumastaimg = $info->gumasta;
              $gumastaimgs = explode(',',$gumastaimg);
            $outletimgs = explode(',',$strimages);
            $clientCategory = explode(',',$categorys);
            $clientamenitys = explode(',',$amenitys);
            foreach($outletimgs as $images){
                $imageNames[] = OutletImage::find($images);     
            }
             foreach($gumastaimgs as $gumastaimages){
                $imagegumasta[] = Upload::find($gumastaimages);     
            }
            $amenities = Amenity::get();
            
             $times = Slot::get();
        $startTime=$endTime=[];
        foreach($times as $time)
        {
             $openTime = new DateTime($time->start_time);
            $closeTime = new DateTime($time->end_time);
                
            
               $startTime[$time->start_time] = $openTime->format("h:i A");
               $endTime[$time->end_time] = $closeTime->format("h:i A");
               
        }
          return view('admin.client.edit',['route'=>$this->route,'single_heading'=>$this->single_heading, 'info'=>$info ,'categories' => $category,'files'=>$imageNames,'gumastaimg'=>$imagegumasta,'amenities'=>$amenities,'clientamenitys'=>$clientamenitys,'cities'=>$cities,'clientCategorys'=>$clientCategory,'startTime'=>$startTime,'endTime'=>$endTime,'states'=>$states]);
    }

    public function update(Request $request)
    {
   
        $validator = Validator::make(
            $request->all(),
            [
                    'name'=>'required',
                    'email'=>'required',
                    'username'=>'required',
                    'category_id'=>'required',
                    'outlet_name'=>'required',
                    'ownerAdharCard'=>'required|min:12',
                    'opentime'=>'required',
                    'closetime'=>'required',
                    'file_id'=>'required',
                    'outletAddress'=>'required',
                    // 'bankName'=>'required',
                    // 'accountHolderName'=>'required',
                    // 'accountNumber'=>'required',
                    // 'ifscCode'=>'required',
                    'gumasta_images_id.*'=>'required',
                    'amenity_id.*'=>'required',
                    'logitude'=>'required',
                    'latitude'=>'required',
                    'phoneNumber'=>'required',
                    'cities'=>'required',
                    'state'=>'required',
                    'agreement_images_id.*'=>'required',
                    'gumasta_images_id.*'=>'required',
                    'outlet_images_id.*'=>'required',
            ],[
                'file_id.required' => 'Client Image field is required',
                 'gumasta_images_id.*'=>'Gumasta Image field is required',
                'outlet_images_id.*'=>'Outlet Images field is required',
                'amenity_id.*'=>'Amenities field is required',
                'category_id'=>'Category field is required',
            ]
          );  
          
          if($validator->fails())
          {
            return response()->json(['status'=>0 ,'errors'=>$validator->errors()]);
          }else{
            $images = $request->outlet_images_id;
            $category = $request->category_id;
            $multipleImages = implode(',',$images);
             $image = $request->gumasta_images_id;
            $gumastaImages = implode(',',$image);
            //   echo "<pre>"; print_r($request->toArray()); die;
         Client::find($request->id)->fill([
                        'name'=>$request->name,
                        'email'=>$request->email,
                        'username'=>$request->username,
                        'category_id'=>$category,
                        'outlet_name'=>$request->outlet_name,
                        'owner_adhar_card'=>$request->ownerAdharCard,
                        'opentime'=>$request->opentime,
                        'closetime'=>$request->closetime,
                        'owner_photo'=>$request->file_id,
                        'gumasta'=> $gumastaImages,
                        'outlet_images'=>$multipleImages,
                        'latitude'=>$request->latitude,
                        'longitude'=>$request->logitude,
                        'owner_phonenumber'=>$request->phoneNumber,
                        'city'=>$request->cities,
                        'tax'=>$request->tax,
                        'outlet_address'=>$request->outletAddress,
                        'state_id'=>$request->state,
                        
            ])->save();
                    //   Bank_detail::where('id', $request->bankDetailId)->update([
                    //       'acc_hold_name'=>$request->accountHolderName,
                    //         'account_number'=>$request->accountNumber,
                    //         'bank_name'=>$request->bankName,
                    //         'ifsc_code'=>$request->ifscCode,
                    //         'client_id'=>$request->id,
                    //         ]);

                            // $clientamenity = ClientAmenity::where('client_id',$request->id)->get();
                            ClientAmenity::where('client_id',$request->id)->delete();

                            $amenities = $request->amenity_id; 
                            foreach($amenities as $amenity){
                                      ClientAmenity::create([
                                        'amenities_id'=>$amenity,
                                        'client_id'=>$request->id,
                                        ]);      
                                 }
                            $amenityId = implode(',',$amenities);
                            Client::find($request->id)->fill([
                                        'amenities_id'=>$amenityId,
                                   ])->save();

            return response()->json(['status'=> 1 , 'message' => $this->single_heading .' updated successfully']);
    
          }
    }

    public function destroy($id)
    {
          $delt = Client::destroy($id);
          return response()->json(['status'=>1, 'message' => $this->single_heading . ' deleted successfully']);
    }

    public function clientdetails($id)
    {
                $clientProfile = Client::find($id);
        return view('admin.client.details.clientdetail',['single_heading' => $this->single_heading,'route'=> $this->route,'clientProfile'=>$clientProfile,'Personal'=>'']);
    }
    public function clientprofiledetails(Request $request)
    {
        $clientProfile = Client::find($request->cId);
        return view('admin.client.details.clientprofiledetails',['single_heading' => $this->single_heading,'route'=> $this->route,'clientProfile'=>$clientProfile,'Personal'=>'Personal']);  
    }

    public function clientamenitiesdetails(Request $request)
    {
            $amenities = ClientAmenity::with('allAmentiy')->where('client_id',$request->cId)->get();
      return view('admin.client.details.clientamenitiesdetails',['single_heading' => $this->single_heading,'route'=> $this->route,'amenities'=> $amenities,'Personal'=>'Amenities']);
    }
    public function clientservicesdetails(Request $request)
    {
        $services = ClientServicePrice::with('CatId:id,title','subCate:id,title')->where('client_id',$request->cId)->get();
        // echo "<pre>"; print_r($services->toArray()); die;
       return view('admin.client.details.clientservices',['single_heading' => $this->single_heading,'route'=> $this->route,'services'=> $services,'Personal'=>'Services']);
    }

    public function clientAppointment(Request $request)
    {

        return view('admin.client.details.clientAppointment',['single_heading' => $this->single_heading,'route'=> $this->route,'client_id'=>$request->cId,'Personal'=>'Services']);
    }

    public function clientAppointmentList(Request $request)
    {
        $appointments = Appointment::with('userData:id,name,mobile_number','timeSlot:id,start_time')->where('client_id',$request->cid)->get();

        $draw = $request->draw;
        $row = $_POST['start'];
        $rowperpage = $_POST['length']; 
        $columnIndex = $_POST['order'][0]['column']; 
        $columnName = $_POST['columns'][$columnIndex]['data']; 
        $columnSortOrder = $_POST['order'][0]['dir']; 
        $searchValue = $_POST['search']['value']; 
         $cid = $_POST['cid'];
         $qry = Appointment::with('userData:id,name,mobile_number','timeSlot:id,start_time')->where('client_id',$request->cid);
                $flterAppointmet = $_POST['flterAppoit'];
                if($flterAppointmet == 0)
                {
                    $qry = $qry->where('date',date('Y-m-d'));
                }else if($flterAppointmet == 1)
                {
                    $qry = $qry->where('date','<',date('Y-m-d'));
                }else if($flterAppointmet == 2)
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
            $serEdit_url = $this->route->clientAppointmentListDetails;

              $action = '<div class="d-flex  order-actions">';
              $action .= '<a class="btn btn-outline-primary btn-sm" href="javascript:void(0);" onclick=showAppointments("'.$serEdit_url.'",'.$row->id.');>Details</a>';
              $action .= '</div>';
  
              $data[] = array(
                  "sno" => $i,
                  "username"=>ucfirst(@$row->userData->name),
                  "usermobilenumber"=>$row->userData->mobile_number,
                  "date"=>@$row->date,
                  "time"=>@$row->timeSlot->start_time,
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

    public function clientAppointmentListDetails(Request $request)
    {
        $appointmentdetailes = AppointmentDetaile::with('clientServePriceData')->where('appointments_id',$request->id)->get();
        $appointment = Appointment::where('id',$request->id)->first();
        // echo "<pre>"; print_r($appointmentdetailes->toArray()); die;
        return view('admin.client.details.clientAppointmentDetails',['single_heading' => $this->single_heading,'route'=> $this->route,'appointmentdetailes'=>$appointmentdetailes,'appointment'=>$appointment]);

    }

    public function clientupdateprofiledata(Request $request)
    {
   
        $validator = Validator::make(
            $request->all(),
            [
                    'name'=>'required',
                    'email'=>'required',
                    'username'=>'required',
                    
            ]); 
          
          if($validator->fails())
          {
            return response()->json(['status'=>0 ,'error'=>$validator->errors()]);
          }else{
         
         Client::find($request->id)->fill([
                        'name'=>$request->name,
                        'email'=>$request->email,
                        'username'=>$request->username,
            ])->save();
                      
            return response()->json(['status'=> 1 , 'message' => $this->single_heading .' updated successfully','name'=>$request->name,'email'=>$request->email,'username'=>$request->username,]);
    
          }
               
    }

    public function clientupdateprofiledetails(Request $request)
    {
        $type = $request->type;
        $path = $type . '_path';
        $name = $type . '_name';
        $file_name = $request->$name;
        $file_path = $request->$path;
        $file = $request->file('image');

            if (!empty($file)) {
                $ext = $file->getClientOriginalExtension();
        
                $destinationPath = public_path().'/'.$file_path;
                $file_name = time().rand(1,10000).".".$file->getClientOriginalExtension();
                $file->move($destinationPath,$file_name);
                 $movedFile =  $file_name;
                 
                $file_data= Upload::create([
                    'file'=>$movedFile,
                ]);
                  
                Client::find($request->cid)->fill([
                    'owner_photo'=>$file_data->id,
                ])->save();

                return response()->json(['status' => 1, 'file_id' => $file_data->id, 'file_path' => asset($file_path . $file_data->file)]);

        }else{ 

            return response()->json(['status' => 0, 'msg' => 'File type not allowed']);
        }
    }


    public function addservices($id)
    {
        $categories = Category::where('status',1)->get();
        $subcategories = SubCategory::where('status',1)->get();
        $cid = Client::find($id);
        return view('admin.client.addservices',['single_heading'=>$this->single_heading,'route'=>$this->route, 'categories'=> $categories, 'cid'=>$cid,'subcategories'=>$subcategories]);
    }

    public function storeservices(Request $request)
    {
            $validator = Validator::make(
                $request->all(),
                [
                    'services'=>'required',
                    'category_id'=>'required', 
                    'price'=>'required', 
                    'Sub_category'=>'required', 
                ]
            );
                if($validator->fails()){
                    return response()->json(['status' => 0,'errors' =>  $validator->errors()]);
                }else{
                             
                                ClientServicePrice::create([
                                        'services' => $request->services,
                                        'client_id' => $request->client_id,
                                        'category_id' => $request->category_id,
                                        'sub_category_id' =>$request->Sub_category,
                                        'price'   => $request->price,
                                    ]);
                            
                        
                 return response()->json(['status' => 1, 'message' =>'Services saved successfully']);

                }
    }

    public function clientServicesList(Request $request)
    {
     
        $draw = $request->draw;
        $row = $_POST['start'];
        $rowperpage = $_POST['length']; 
        $columnIndex = $_POST['order'][0]['column']; 
        $columnName = $_POST['columns'][$columnIndex]['data']; 
        $columnSortOrder = $_POST['order'][0]['dir']; 
        $searchValue = $_POST['search']['value']; 
         $cid = $_POST['cid'];
        $qry = ClientServicePrice::with(['category:id,title','subCate:id,title'])->orderBy($columnName, $columnSortOrder)->where('client_id','=',$cid);
        $result = $qry->get();
            // echo "<pre>"; print_r($result->toArray()); die;
        $totalRecordwithFilter = $totalRecords = $qry->count();
        $result = $qry->offset($row)->take($rowperpage)->get();
        $data = array();
        $i = 1;
       
          foreach ($result as $row) {
            $serEdit_url = $this->route->clientServicesEdit;
            $serdestroy = $this->route->clientServicesDestory; 

              $action = '<div class="d-flex  order-actions">';
              $action .= '<a href="javascript:void(0);" onclick=edit_row("'.$serEdit_url.'",'.$row->id.');><i class="la-user-edit la"></i></a>';
           $action .= '&nbsp;&nbsp;<a href="javascript:void(0);"onclick=delete_row("'.$serdestroy.'",'.$row->id.')><i class="feather icon-trash-2"></i></a>';
              $action .= '</div>';
  
              $data[] = array(
                  "sno" => $i,
                  "services"=>ucfirst(@$row->services),
                  "price"=>'₹'.$row->price,
                  "category"=>@$row->category->title,
                  "subcategory"=>@$row->subCate->title,
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

    public function imageupload(Request $request)
    {
//dd($request->all());
        $type = $request->type;
        $path = $type . '_path';
        $name = $type . '_name';
        $file_name = $request->$name;
        $file_path = $request->$path;
        $file = $request->file('image');

            if (!empty($file)) {
                $ext = $file->getClientOriginalExtension();
        
                $destinationPath = public_path().'/'.$file_path;
                $file_name = time().".".$file->getClientOriginalExtension();
                $file->move($destinationPath,$file_name);
                 $movedFile =  $file_name;
                 
                $file_data= Upload::create([
                    'file'=>$movedFile,
                ]);

                return response()->json(['status' => 1, 'file_id' => $file_data->id, 'file_path' => asset($file_path . $file_data->file)]);

        }else{ 

            return response()->json(['status' => 0, 'msg' => 'File type not allowed']);
        }
    }

  public function gumastaimgupload(Request $request)
    {
        $type = $request->type;
        $path = $type . '_path';
        $name = $type . '_name';
        $file_name = $request->$name;
        $file_path = '/uploads/gumasta/';
        $file = $request->file('gumasta_images');
        $movedFile=$file_data=$file_ids=$files=array();
        if (!empty($file)) {
            
                $destinationPath = public_path().'/'.$file_path;
                foreach($file as $value)
                {
                    $ext = $value->getClientOriginalExtension();
                    $file_name = time().rand(1,2000).".".$value->getClientOriginalExtension();
                    $value->move($destinationPath,$file_name);
                    $movedFile[] =  $file_name;  
                }
                $view = array();
                foreach($movedFile as $values)
                {
                    $file_data= Upload::create([
                        'file'=>$values,
                    ]);
                    
                    // echo "<pre>";print_r($file_data);die;
                    
                    $file_ids[]= $file_data->id;
                //    $view = url('/uploads/gumasta/'.$values); 
                }
                
                
                $oldids= implode(',',$file_ids);
             
                   $oldIdarr = explode(',',$oldids);
                    $allids = array_filter(array_merge($file_ids,$oldIdarr));
                    $files = Upload::whereIn('id', $allids)->get();
                    $view  =  view('admin.client.gumastamultiple',['files'=>$files,'route' => $this->route])->render();
                 return response()->json(['status' => 1, 'file_id' => $file_ids, 'file_path' => $view ]);
        }else{ 

            return response()->json(['status' => 0, 'msg' => 'File type not allowed']);
        }
    }

    public function outletimagesupload(Request $request)
    {
        $type = $request->type;
        $path = $type . '_path';
        $name = $type . '_name';
        $file_name = $request->$name;
        $file_path = $request->$path;
        $file = $request->file('outlet_images');

        $movedFile=$file_data=$file_ids=$files=array();
            if (!empty($file)) {
                
                $destinationPath = public_path().'/'.$file_path;
                foreach($file as $value)
                {
                    $ext = $value->getClientOriginalExtension();
                    $file_name = time().rand(1,2000).".".$value->getClientOriginalExtension();
                    $value->move($destinationPath,$file_name);
                    $movedFile[] =  $file_name;  
                }
                foreach($movedFile as $values)
                {
                      $file_data= OutletImage::create([
                            'file'=>$values,
                        ]);

                       $file_ids[]= $file_data->id;
                    }

                   $oldids= implode(',',$request->outlet_images_id);
                   $oldIdarr = explode(',',$oldids);
                    $allids = array_filter(array_merge($file_ids,$oldIdarr));
                    $files = OutletImage::whereIn('id', $allids)->get();
                    $view  =  view('admin.client.multipleimg',['files'=>$files,'route' => $this->route])->render();
                 return response()->json(['status' => 1, 'file_id' => $allids, 'file_path' =>$view ]);

        }else{ 

            return response()->json(['status' => 0, 'msg' => 'File type not allowed']);
        }
    }

    public function clientServicesEdit($id)
    {
        
        $categories = Category::where('status',1)->get();
        $subcat = SubCategory::where('status',1)->get();
        $cid = ClientServicePrice::find($id);
        return view('admin.client.editservices',['single_heading'=>$this->single_heading,'route'=>$this->route, 'categories'=> $categories, 'spriceid'=>$cid,'subcat'=>$subcat]);
    }


    public function clientServicesUpdate(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'services'=>'required',
                'category_id'=>'required', 
                'price'=>'required', 
                'Sub_category'=>'required',  
            ]
        );
        if($validator->fails()){
            return response()->json(['status' => 0,'errors' =>  $validator->errors()]);
        }else{
                    // echo "<pre>"; print_r($request->toArray()); die;
             ClientServicePrice::find($request->id)->fill([
                'services'=>$request->services,
                'category_id'=>$request->category_id,
                'sub_category_id'=>$request->Sub_category,
                'price'=>$request->price,
             ])->save();

            $cId= ClientServicePrice::find($request->id);
            return response()->json(['status' => 1, 'message' =>'Services saved successfully','id'=>$cId->client_id]);
            

        }
    }

    public function clientServicesDestory($id)
    {
        ClientServicePrice::destroy($id);
    return response()->json(['status'=>1, 'message' => $this->single_heading . ' deleted successfully']);
    }

    public function multipleimagedelete(Request $request)
    {
        $id = $request->id;
        $ids = explode(',', $request->ids);

        $ids = array_values(array_diff($ids, array($id)));
        return implode(',', $ids);
    }

    public function status(Request $request)
    {
        $status = Client::find($request->id);
        $status->status = $request->status;
        $status->save();
        return response()->json(['success' => 1, 'message' => $this->single_heading . ' status changed successfully']);
    }
    

    public function addholiday($id)
    {
        $cid = Client::find($id);
        return view('admin.client.addholidayes',['single_heading'=>$this->single_heading,'route'=>$this->route, 'cid'=>$cid,]);
    }

    public function holidayLis(Request $request)
    {
     
        $draw = $request->draw;
        $row = $_POST['start'];
        $rowperpage = $_POST['length']; 
        $columnIndex = $_POST['order'][0]['column']; 
        $columnName = $_POST['columns'][$columnIndex]['data']; 
        $columnSortOrder = $_POST['order'][0]['dir']; 
        $searchValue = $_POST['search']['value']; 
         $cid = $_POST['cid'];
        $qry = Holiday::orderBy($columnName, $columnSortOrder)->where('client_id','=',$cid);
        $result = $qry->get();

        //  echo "<pre>"; print_r($result->toArray()); die;
        $totalRecordwithFilter = $totalRecords = $qry->count();
        $result = $qry->offset($row)->take($rowperpage)->get();
        $data = array();
        $i = 1;
       
          foreach ($result as $row) {
            $Editholiday_url = $this->route->editholiday;
            $destroy = $this->route->holidayDestory; 

              $action = '<div class="d-flex  order-actions">';
              $action .= '<a href="javascript:void(0);" onclick=edit_row("'.$Editholiday_url.'",'.$row->id.');><i class="la-user-edit la"></i></a>';
           $action .= '&nbsp;&nbsp;<a href="javascript:void(0);"onclick=delete_row("'.$destroy.'",'.$row->id.')><i class="feather icon-trash-2"></i></a>';
              $action .= '</div>';
  
              $data[] = array(
                  "sno" => $i,
                  "date"=>$row->date,
                  "title"=>@$row->title,
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


    public function storeHoliday(Request $request)
    {
            $validator = Validator::make(
                $request->all(),
                [
                    'date'=>'required',
                    'title'=>'required', 
                ]
            );
                if($validator->fails()){
                    return response()->json(['status' => 0,'errors' =>  $validator->errors()]);
                }else{
                    $dateTime = DateTime::createFromFormat('d/m/Y', $request->date);
                    $formattedDate = $dateTime->format('Y-m-d');
                    // echo "<pre>"; print_r($formattedDate); die;
                    
                                Holiday::create([
                                        'date' => $formattedDate,
                                        'client_id' => $request->client_id,
                                        'title'=> $request->title,
                                    ]);
                             
                 return response()->json(['status' => 1, 'message' =>'Services saved successfully']);

                }
    }

    public function editHoliday($id)
    {
        $cid = Holiday::find($id);
        // echo "<pre>"; print_r($cid->toArray()); die;
        return view('admin.client.editholiday',['single_heading'=>$this->single_heading,'route'=>$this->route,'holiday'=>$cid,]);
    }


    public function updateholiday(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'date'=>'required',
                    'title'=>'required', 
            ]
        );
        if($validator->fails()){
            return response()->json(['status' => 0,'errors' =>  $validator->errors()]);
        }else{
           $holiday = Holiday::find($request->id);
        //    echo "<pre>"; print_r($holiday); die;
           if($holiday->date == $request->date){
            Holiday::find($request->id)->fill([
                'date' => $request->date,
                'title'=> $request->title,
             ])->save();
           }else{
            $dateTime = DateTime::createFromFormat('d/m/Y', $request->date);
            $formattedDate = $dateTime->format('Y-m-d');
            Holiday::find($request->id)->fill([
                'date' => $formattedDate,
                'title'=> $request->title,
             ])->save();
           }
            
                  

            $cId= Holiday::find($request->id);
            return response()->json(['status' => 1, 'message' =>'Services saved successfully','id'=>$cId->client_id]);
            

        }
    }

    public function holidayDestroy($id)
    {
        Holiday::destroy($id);
    return response()->json(['status'=>1, 'message' => $this->single_heading . ' deleted successfully']);
    }

    public function addslot($id)
    {
        $client = Client::find($id);
        $indiaTime = Carbon::now('Asia/Kolkata');
        $formattedTime = $indiaTime->format("h:i A");  
        $formattedTimeCarbon = Carbon::createFromFormat("h:i A", $formattedTime);
        $slots = Slot::with(['bookedSlot'=> function ($query) use($client,$formattedTimeCarbon) { $query->where('client_id',$client->id); $query->where('date',$formattedTimeCarbon); }])->where('start_time','>=',$client->opentime)->where('start_time','<=',$client->closetime)->get();
        // echo "<pre>"; print_r($slots->toArray()); die;
        return view('admin.client.slot.addSloat',['single_heading'=>$this->single_heading,'route'=>$this->route,'slots'=>$slots,'client_id'=>$client->id]);
    }

    public function slotWithDate(Request $request)
    {
        // echo "<pre>"; print_r($request->toArray()); die;
        $client = Client::find($request->client_id);
        $slots = Slot::with(['bookedSlot'=> function ($query) use($client,$request) { $query->where('client_id',$client->id);$query->where('date',$request->date); }])->where('start_time','>=',$client->opentime)->where('start_time','<=',$client->closetime)->get();

        $slotwithDate = view('admin.client.slot.slotwithdate',['single_heading'=>$this->single_heading,'route'=>$this->route,'slots'=>$slots,'client_id'=>$client->id])->render();
        return response()->json(['status'=>1, 'message' => 'Slot change successfully','slotwithDate' =>$slotwithDate]);  
    }

    public function slotAvailability(Request $request)
    {
        // echo "<pre>"; print_r($request->toArray()); die;
       $slotavailavle =  SlotAvailability::where('client_id',$request->cId)->where('slot_id',$request->slot)->first();
       if($slotavailavle){
          
        $slot = SlotAvailability::where('client_id',$request->cId)->where('slot_id',$request->slot)->first();
        SlotAvailability::destroy($slot->id);
        return response()->json(['status'=>0, 'message' => 'Slot deleted successfully','slot_id'=>$request->slot]);
       }else{
        $newdate = new DateTime($request->date);
        $date = $newdate->format("Y-m-d");
           $info = SlotAvailability::create([
               'client_id'=> $request->cId,
               'slot_id'=> $request->slot,
               'date'=> $date,
               ]);
              $slotss = Slot::find($request->slot);
              $openTime = new DateTime($slotss->start_time);
              $closeTime = new DateTime($slotss->end_time);
              $startTime = $openTime->format("h:i A");
              $endTime = $closeTime->format("h:i A");
              $slotpage = view('admin.client.slot.slotAdded',['endTime'=>$endTime,'startTime'=>$startTime,'route'=>$this->route,'client_id'=>$request->cId,'slot_id'=>$request->slot])->render();

                //  echo "<pre>"; print_r($slotpage); die;
               return response()->json(['status'=>1, 'message' => 'Slot change successfully','slot_id'=>$request->slot,'pageslot' =>$slotpage]);  
       }
    }


 
}
