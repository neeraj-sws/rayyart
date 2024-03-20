<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\{Advertisment,Upload};
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class AdvertismentController extends Controller
{
    protected $route;

    protected $single_heading;

    public function __construct()
    {
        $this->route = new \stdClass;
        $this->single_heading = "Advertisment";
        $this->route->list = route('admin.advertisment.list');
        $this->route->add = route('admin.advertisment.add');
        $this->route->store = route('admin.advertisment.store');
        $this->route->saveimage = route('admin.advertisment.saveimage');
        $this->route->status = route('admin.advertisment.status');
        $this->route->edit = route('admin.advertisment.edit',':id');
        $this->route->destory = route('admin.advertisment.destroy',':id');

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.advertisment.index',['single_heading'=> $this->single_heading , 'route'=>$this->route]);
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

      $qry = Advertisment::orderBy($columnName, $columnSortOrder)->where('title', 'LIKE', '%' . $searchValue . '%') ->orWhere('description', 'LIKE', '%' . $searchValue . '%');
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

            $status_url = $this->route->status;

            if($row->status == 1){
                $status = '<a href="javascript:void(0);" class="d-flex align-items-center text-success" onclick=status_change("'.$status_url.'",0,'.$row->id.');><span class="badge-dot me-2 bg-success"></span><span class="text-capitalize">active</span></a>';
            }else{
                $status = '<a href="javascript:void(0);" class="d-flex align-items-center text-danger"  checked="" onclick=status_change("'.$status_url.'",1,'.$row->id.');><span class="badge-dot me-2 bg-danger"></span><span class="text-capitalize">Inactive</span></a>';
            }

            $file='';
            if ($row->photo) {
                $file = '<img src="' . asset('uploads/advertisment/'.@$row->photo->file) . '" class="img-fluid table-image" alt="" width="50" height="50" >';
            }

            $data[] = array(
                "sno" => $i,
                "image"=>$file,
                "title"=>ucfirst($row->title),
                "description"=>ucfirst($row->description),
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.advertisment.add',['route'=> $this->route , 'single_heading'=> $this->single_heading]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->id){
            return $this->update($request);
            }else{
            $validator = Validator::make(
                $request->all(),
                [
                    'title'=>'required',
                    'file_id'=>'required',
                    'description'=>'required',
                    'status'=>'required',
                ]
            );
                if($validator->fails()){
                    return response()->json(['status' => 0,'errors' =>  $validator->errors()]);
                }else{
                    $info = Advertisment::create([
                        'title'=>$request->title,
                        'image'=>$request->file_id,
                        'description'=>$request->description,
                        'status'=>$request->status,
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

    /**
     * Display the specified resource.
     */
    public function status(Request $request)
    {
        $status = Advertisment::find($request->id);
        $status->status = $request->status;
        $status->save();
        return response()->json(['success' => 1, 'message' => $this->single_heading . ' status changed successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $info = Advertisment::find($id);
        return view('admin.advertisment.edit',['route'=>$this->route,'single_heading'=>$this->single_heading, 'info'=>$info]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title'=>'required',
                'file_id'=> 'required',
                'description'=>'required',
                'status'=>'required',
            ]
          );  
          
          if($validator->fails())
          {
            return response()->json(['status'=>0 ,'error'=>$validator->errors()]);
          }else{
            Advertisment::find($request->id)->fill([
                'title'=>$request->title,
                'image'=>$request->file_id,
                'description'=>$request->description,
                'status'=>$request->status,
            ])->save();
            return response()->json(['status'=> 1 , 'message' => $this->single_heading .' updated successfully']);
    
          }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Advertisment::destroy($id);
          return response()->json(['status'=>1, 'message' => $this->single_heading . ' deleted successfully']);
    }
}
