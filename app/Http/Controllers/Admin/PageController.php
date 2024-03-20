<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Pages;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $route;

    protected $single_heading;

    public function __construct()
    {
          $this->route = new \stdClass;
          $this->single_heading = "Pages";
          $this->route->list = route('admin.pages.list');
          $this->route->add = route('admin.pages.add');
          $this->route->store = route('admin.pages.store');
          $this->route->edit = route('admin.pages.edit','');
         
    }

    public function index()
    {
           return view('admin.pages.index',['route'=>$this->route, 'single_heading'=>$this->single_heading]);
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
  
        $qry = Pages::orderBy($columnName, $columnSortOrder)->where('title', 'LIKE', '%' . $searchValue . '%') ->orWhere('slug', 'LIKE', '%' . $searchValue . '%');
        $result = $qry->get();
  
        $totalRecordwithFilter = $totalRecords = $qry->count();
        $result = $qry->offset($row)->take($rowperpage)->get();
        $data = array();
        $i = 1;
          foreach ($result as $row) {
              $edit_url = $this->route->edit;
              $action = '<div class="d-flex  order-actions">';
              $action .= '<a href="'.$edit_url.'/'.$row->id.'"><i class="la-user-edit la"></i></a>';
              $action .= '</div>';

              $data[] = array(
                  "sno" => $i,
                  "title"=>ucfirst($row->title),
                  "slug"=>($row->slug),
                  "description"=>($row->description),
                  "action" => $action,
              );
  
              $i++;
          }
                  $response = array(
                      "draw" => intval($draw),
                      "iTotalRecords" => $totalRecords,
                      "iTotalDisplayRecords" => $totalRecordwithFilter,
                      "aaData" => $data
                  );
          
                  echo json_encode($response);
    }

    public function store(Request $request)
    {
        if($request->id){
            return $this->update($request);
            }else{
            $validator = Validator::make(
                $request->all(),
                [
                    'title'=>'required',
                    'slug'=>'required',
                    'description'=>'required',
                ]
            );

         if($validator->fails()){
                    return response()->json(['status' => 0,'errors' =>  $validator->errors()]);
                }else{
                    $info = Pages::create([
                        'title'=>$request->title,
                        'slug'=>$request->slug,
                        'description'=>$request->description,
                    ]);
                    
                    return response()->json(['status' => 1, 'message' => $this->single_heading .'saved successfully']);
                };
            }
            
    }


    public function edit($id)
    {
        $info = Pages::find($id);
        return view('admin.pages.edit',['route'=>$this->route,'single_heading'=>$this->single_heading, 'info'=>$info]);
    }

  
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title'=>'required',
                'slug'=> 'required',
                'description'=>'required',
            ]
          );  
          
          if($validator->fails())
          {
            return response()->json(['status'=>0 ,'error'=>$validator->errors()]);
          }else{
            $info= Pages::find($request->id)->fill([
                'title'=>$request->title,
                'slug'=>$request->slug,
                'description'=>$request->description,
                
            ])->save();
            return response()->json(['status'=> 1 , 'message' => $this->single_heading .' updated successfully']);
         
          }
    }

   


}