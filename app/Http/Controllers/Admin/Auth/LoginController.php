<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Category,Client,Services,Amenity};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{     
    protected $route;

    protected $single_heading;
    public function __construct()
    {
          $this->route = new \stdClass;
          $this->single_heading = "Dashboard";
    }
     //todo: admin login form
     public function login_form()
     {
        return view('admin.auth.login'); 
     }
 
     //todo: admin login functionality
     public function login_functionality(Request $request){
       
         $request->validate([
             'email'=>'required',
             'password'=>'required',
         ]);
         if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
             return redirect()->route('admin.dashboard');
         }else{
             Session::flash('error-message','Invalid Email or Password');
             return back();
         }
     }
 
     public function dashboard()
     {
        $clients   = Client::get()->count();
        $categorys = Category::get()->count();
        $services  = Services::get()->count();
        $amenity   = Amenity::get()->count();
         return view('admin.dashboard',['single_heading'=>$this->single_heading,'clients'=>$clients,'categorys'=>$categorys,'services'=>$services,'amenity'=>$amenity]);
     }
 
 
     //todo: admin logout functionality
     public function logout(){
         Auth::guard('admin')->logout();
         return redirect()->route('admin.adminlogin.form');
     }
}