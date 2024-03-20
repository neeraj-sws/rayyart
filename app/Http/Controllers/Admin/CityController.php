<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User,City,State};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    protected $route;

    protected $single_heading;
   public function __construct()
   {

    $this->route = new \stdClass;
    $this->single_heading = "City";
    $this->route->list = route('admin.city.list');
    $this->route->add = route('admin.city.add');
    $this->route->store = route('admin.city.store');
    $this->route->status = route('admin.city.status');
    $this->route->edit = route('admin.city.edit',':id');
    $this->route->destory = route('admin.city.destroy',':id');
   }

   public function index()
   {
    return view('admin.city.index',['single_heading'=>$this->single_heading, 'route'=> $this->route]);
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

      $qry = City::orderBy($columnName, $columnSortOrder)->where('name', 'LIKE', '%' . $searchValue . '%');
      $result = $qry->get();

      $totalRecordwithFilter = $totalRecords = $qry->count();
      $result = $qry->offset($row)->take($rowperpage)->get();
      $data = array();
      $i = 1;
        foreach ($result as $row) {

            $status_url = $this->route->status;
            if($row->status == 1){
                $status = '<a href="javascript:void(0);" class="d-flex align-items-center text-success"  onclick=status_change("'.$status_url.'",0,'.$row->id.');><span class="badge-dot me-2 bg-success"></span><span class="text-capitalize">active</span></a>';
            }else{
                $status = '<a href="javascript:void(0);" class="d-flex align-items-center text-danger" checked="" onclick=status_change("'.$status_url.'",1,'.$row->id.');><span class="badge-dot me-2 bg-danger"></span><span class="text-capitalize">Inactive</span></a>';
            }
     
            $edit_url = $this->route->edit;
            $destroy = $this->route->destory;
            $action = '<div class="d-flex  order-actions">';
            $action .= '<a href="javascript:void(0);" onclick=edit_row("'.$edit_url.'",'.$row->id.');><i class="la-user-edit la"></i></a>';
            $action .= '&nbsp;&nbsp;<a href="javascript:void(0);"onclick=delete_row("'.$destroy.'",'.$row->id.')><i class="feather icon-trash-2"></i></a>';
            $action .= '</div>';


            $data[] = array(
                "sno" => $i,
                "name"=>ucfirst($row->name),
                "status"=>$status,
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
    return view('admin.city.add',['route'=>$this->route,'single_heading'=>$this->single_heading,
    'states'=>$states]);
   }
   public function store(Request $request)
   {
   
    if($request->id){
            return $this->update($request);
    }else{
        // echo "<pre>"; print_r($request->toArray()); die;
    $validator = Validator::make(
        $request->all(),
        [
            'name'=>'required',
            'state'=>'required',
            'latitude'=>'required',
            'longitude'=>'required',
        ]
    );
        if($validator->fails()){
            return response()->json(['status' => 0,'errors' =>  $validator->errors()]);
        }else{

            $info = City::create([
                'name'=>$request->name,
                'state_id'=>$request->state,
                'status'=>$request->status,
                'latitude'=>$request->latitude,
                'longitude'=>$request->longitude,
            ]);

            return response()->json(['status' => 1, 'message' => $this->single_heading .'saved successfully' ]);
        }
    }

   }

   public function edit($id)
   {
        $info = City::find($id);
        $states = State::where('status',1)->get();
       return view('admin.city.edit',['info'=>$info,'route'=>$this->route,'single_heading'=>$this->single_heading,'states'=>$states]);
   }

   public function update(Request $request)
   {
      $validator = Validator::make(
        $request->all(),
        [
            'name'=>'required',
            'state'=>'required',
            'latitude'=>'required',
            'longitude'=>'required',
        ]
      );  
      
      if($validator->fails())
      {
        return response()->json(['status'=>0 ,'error'=>$validator->errors()]);
      }else{
        City::find($request->id)->fill([
            'name'=>$request->name,
            'state_id'=>$request->state,
            'status'=>$request->status,
            'latitude'=>$request->latitude,
            'longitude'=>$request->longitude,
        ])->save();
        return response()->json(['status'=> 1 , 'message' => $this->single_heading .' updated successfully']);

      }
   }

   public function destroy($id)
   {
     $delt= City::destroy($id);
     return response()->json(['status'=>1, 'message' => $this->single_heading . ' deleted successfully']);
   }

   public function status(Request $request)
   {
       $status = City::find($request->id);
       $status->status = $request->status;
       $status->save();
       return response()->json(['success' => 1, 'message' => $this->single_heading . ' status changed successfully']);
   }

}
