<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\{Subscription,Upload};
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $route;

    protected $single_heading;

    public function __construct()
    {
          $this->route = new \stdClass;
          $this->single_heading = "Subscription";
        //$this->route->list = route('admin.subscription.list');
          $this->route->add = route('admin.subscription.add');
          $this->route->store = route('admin.subscription.store');
          $this->route->saveimage = route('admin.subscription.saveimage');
          $this->route->status = route('admin.subscription.status');
          $this->route->edit = route('admin.subscription.edit',':id');
          $this->route->destroy = route('admin.subscription.destroy',':id');

    }


    public function index()
    {   
           $user =Subscription::all();
           return view('admin.subscription.index',['route'=>$this->route, 'single_heading'=>$this->single_heading ,
           'users'=>$user ]);
    }

    public function create()
    {
        return view('admin.subscription.add',['route'=> $this->route , 'single_heading'=> $this->single_heading]);
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
                    'validation'=>'required',
                    'price'=>'required',
                    'status'=>'required',
                ]
                
            );
                if($validator->fails()){
                    return response()->json(['status' => 0,'errors' =>  $validator->errors()]);
                }else{
                    $info = Subscription::create(array(
                        'title'=>ucfirst($request->title),
                        'validation'=>$request->validation,
                        'price'=>$request->price,
                        'status'=>$request->status,
                        'icon'=>$request->file_id,
                ));
               
                
                    return response()->json(['status' => 1, 'message' => $this->single_heading .'saved successfully' ]);
                }
            }
    }

    public function status(Request $request)
    {
   
        $status = Subscription::find($request->id);
        $status->status = $request->status;
        $status->save();
        return response()->json(['success' => 1, 'message' => $this->single_heading . ' status changed successfully']);
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
    
    public function edit(Request $request ,$id)
    {
        $user = Subscription::find($id);
        return view('admin.subscription.edit',['route'=>$this->route,'single_heading'=>$this->single_heading, 'info'=>$user]);
    }


    public function update(Request $request)
    {  
        $validator = Validator::make(
            $request->all(),
            [ 
                'title'=>'required',
                'validation'=>'required',
                'price'=>'required',
                'status'=>'required',
                ]
            );  
            
            if($validator->fails())
            { 
                return response()->json(['status' => 0,'errors' =>  $validator->errors()]);
            }else{
             
            Subscription::find($request->id)->fill([
                'title'=>ucfirst($request->title),
                'validation'=>$request->validation,
                'price'=>$request->price,
                'status'=>$request->status,
                'icon'=>$request->file_id,
                ])->save();
                

            return response()->json(['status'=> 1 , 'message' => $this->single_heading .' updated successfully']);
    
          }
    }

    public function destroy($id)
    {
        Subscription::destroy($id);
          return response()->json(['status'=> 1, 'message' => $this->single_heading . ' deleted successfully']);
    }



}