<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Admin,Upload};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    protected $route;

    protected $single_heading;

    public function __construct()
    {
        $this->route = new \stdClass;
        $this->single_heading = "Admin";
        $this->route->list = route('admin.admins.list');
        $this->route->add = route('admin.admins.add');
        $this->route->store = route('admin.admins.store');
        $this->route->saveimage = route('admin.admins.saveimage');
        $this->route->edit = route('admin.admins.edit',':id');
        $this->route->destory =route('admin.admins.destroy',':id');
        $this->route->adminProfile =route('admin.admins.adminProfile','');
        $this->route->adminProfileImage =route('admin.admins.adminProfileImage','');
        $this->route->adminProfileUpdate =route('admin.admins.adminProfileUpdate');
        $this->route->profileAdmin =route('admin.admins.profileAdmin');
        $this->route->editPassword =route('admin.admins.editPassword');
        $this->route->updatePassword =route('admin.admins.updatePassword');

    }

    public function index()
    {
        return view('admin.admins.index',['single_heading'=> $this->single_heading , 'route'=>$this->route]);
    }

    public function list()
    {
      $draw = $_POST['draw'];
      $row = $_POST['start'];
      $rowperpage = $_POST['length']; 
      $columnIndex = $_POST['order'][0]['column']; 
      $columnName = $_POST['columns'][$columnIndex]['data']; 
      $columnSortOrder = $_POST['order'][0]['dir']; 
      $searchValue = $_POST['search']['value']; 

      $qry = Admin::orderBy($columnName, $columnSortOrder)->where('name', 'LIKE', '%' . $searchValue . '%') ->orWhere('email', 'LIKE', '%' . $searchValue . '%')->orWhere('username', 'LIKE', '%' . $searchValue . '%');
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

                         $file='';
                        if ($row->photo) {
                            $file = '<img src="' . asset('uploads/admin/' . @$row->photo->file) . '" class="img-fluid table-image" alt="" width="50" height="50" >';
                        }

            $data[] = array(
                "sno" => $i,
                "name"=>ucfirst($row->name),
                "username"=>ucfirst($row->username),
                "email"=>$row->email,
                'icon'=>$file,
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
        return view('admin.admins.add',['route'=>$this->route,'single_heading'=>$this->single_heading]);
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
                'username'=>'required',
                'password'=>'required',
            ]
        );
            if($validator->fails()){
                return response()->json(['status' => 0,'errors' =>  $validator->errors()]);
            }else{
                $info = Admin::create([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'username'=>$request->username,
                    'password'=>$request->password,
                    'icon'=>$request->file_id,
                ]);
                return response()->json(['status' => 1, 'message' => $this->single_heading .'saved successfully' ]);
            }
        }
    }


    public function imageupload(Request $request)
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

    public function edit($id)
    {
        $info = Admin::find($id);
        return view('admin.admins.edit',['info'=>$info,'route'=>$this->route,'single_heading'=>$this->single_heading]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'=>'required',
                'username'=>'required',
                'email'=>'required',
            ]
          );  
          
          if($validator->fails())
          {
            return response()->json(['status'=>0 ,'error'=>$validator->errors()]);
          }else{

            $info= Admin::find($request->id)->fill([
                'name'=>$request->name,
                'email'=>$request->email,
                'username'=>$request->username,
                'icon'=>$request->file_id,
            ])->save();

            return response()->json(['status'=> 1 , 'message' => $this->single_heading .' updated successfully']);
    
          }
    }

    public function destroy($id)
    {
        $delt= Admin::destroy($id);
        return response()->json(['status'=>1, 'message' => $this->single_heading . ' deleted successfully']);
    }


    public function adminProfile($id)
    {
        $info = Admin::with('photo')->find($id);
        return view('admin.admins.profile',['info'=>$info,'route'=>$this->route,'single_heading'=>$this->single_heading]); 
    }

    public function profileAdmin(Request $request)
    {
        $info = Admin::with('photo')->find($request->adminId);
        return view('admin.admins.adminProfile',['info'=>$info,'route'=>$this->route,'single_heading'=>$this->single_heading]); 
    }

    public function adminProfileImage(Request $request)
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
                $file_name = time().".".$file->getClientOriginalExtension();
                $file->move($destinationPath,$file_name);
                 $movedFile =  $file_name;
                 
                $file_data= Upload::create([
                    'file'=>$movedFile,
                ]);

                Admin::find($request->adminId)->fill([
                    'icon'=>$file_data->id,
                ])->save();

                return response()->json(['status' => 1, 'file_id' => $file_data->id, 'file_path' => asset($file_path . $file_data->file)]);

        }else{ 

            return response()->json(['status' => 0, 'msg' => 'File type not allowed']);
        }
    }

    public function adminProfileUpdate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'=>'required',
                'username'=>'required',
                'email'=>'required',
            ]
          );  
          
          if($validator->fails())
          {
            return response()->json(['status'=>0 ,'error'=>$validator->errors()]);
          }else{

            $info= Admin::find($request->id)->fill([
                'name'=>$request->name,
                'email'=>$request->email,
                'username'=>$request->username,
            ])->save();

            return response()->json(['status'=> 1 , 'message' => $this->single_heading .' updated successfully']);
    
          }
    }

    public function editPassword(Request $request)
    {
        $info = Admin::with('photo')->find($request->adminId);
        return view('admin.admins.editpassword',['info'=>$info,'route'=>$this->route,'single_heading'=>$this->single_heading]); 
    }

    public function updatePassword(Request $request)
    {


        $validator = Validator::make(
            $request->all(),
            [
                'oldpassword'=>'required',
                'newpassword'=>'required',
            ]
          );  
          
          if($validator->fails())
          {
            return response()->json(['status'=>0,'errors'=>$validator->errors()]);
        }else{

            $admin = Admin::find($request->id);

            if (Hash::check($request->oldpassword, $admin->password)) {
                
                   Admin::find($request->id)->fill([
                'password'=>$request->newpassword,
                     ])->save();
                     return response()->json(['status'=> 1 , 'message' => $this->single_heading .' password updated successfully']);
            } else {
                return response()->json(['status'=>3, 'message' => 'Old password is not match']);
            }

          }
    }


}