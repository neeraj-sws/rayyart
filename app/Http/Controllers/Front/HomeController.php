<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Pages,Faq,CompanyContact};

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('home');
    }


    public function about_us()
    {
        $product = Pages::where('slug', "about-us")->first();
        return view('about_us', compact('product'));
    }

    public function term_condition()
    {
        $product = Pages::where('slug', "terms-condition")->first();
        return view('term_condition', compact('product'));
    }

    public function privacy_policy()
    {
        $product = Pages::where('slug', "privacy-policy")->first();
        return view('privacy_policy', compact('product'));
    }

    public function our_story()
    {
        $product = Pages::where('slug', "our-story")->first();
        // echo"<pre>";print_r($product->toArray());die;
        return view('our_story',compact('product'));
    }
    public function cancellation_refunded()
    {
        $product = Pages::where('slug', "cancellation-refunded")->first();
        return view('cancellation_refunded',compact('product'));
    }
    public function faq()
    {
        $fqu = Faq::get();
        return view('faqs',compact('fqu'));
    }




}
