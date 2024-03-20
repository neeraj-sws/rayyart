<?php

namespace App\Http\Controllers\API\Client;

use App\Http\Controllers\Controller;
use App\Models\{Subscription,Upload};
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;


class ClientSubscriptionController extends Controller
{
    public function getsubscription(Request $request)
    { 

     
    $subscription = Subscription::with(['photo'])->get();

        $founds = $subscription->map(function ($subscription) {
            
            return [
                "id" => $subscription->id,
                "title" => $subscription->title,
                "validation" => $subscription->validation,
                "price" => $subscription->price,
                "status" => $subscription->status,
                "icon" => $subscription->image_url,
            ];
        });
      
        return response()->json([
            'status' => 200,
            "message" => "Subscription Packages List",
            "data" => $founds->all(),
        ]);
      
   
    }

  



}