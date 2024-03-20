<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ClientauthController extends Controller
{
    //todo: admin login form
    public function login_form()
    {
        return view('client.login-form');
    }

    //todo: admin login functionality
    public function login_functionality(Request $request){    
        $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);       
        if (Auth::guard('client')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('dashboard');
        }else{
            Session::flash('error-message','Invalid Email or Password');
            return back();
        }
    }

    public function dashboard()
    {
        return view('client.dashboard');
    }


    //todo: admin logout functionality
    public function logout(){
        Auth::guard('client')->logout();
        return redirect()->route('clientlogin.form');
    }
}
