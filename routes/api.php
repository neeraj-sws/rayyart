<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{AdvertismentController, AppointmentController, AuthController,UserController};
use App\Http\Controllers\API\{ClientController,CategoryController,ServicesController,AmenitiesController};
Use App\Http\Controllers\API\Client\{ClientAuthController,ClientInfoController,ClientServicesController,ClientHolidayController,ClientSlotController,ClientAppointmentController,ClientSubscriptionController};



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::get('info', [UserController::class, 'info'])->middleware('auth:sanctum');
Route::controller(AuthController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('create-otp','createOTP');
    Route::post('submit-otp','submitOTP');
    Route::post('social-login','socialLogin');
});


Route::group(['middleware' => ['auth:sanctum','ability:user']], function() {
    
    Route::post('changePassword', [AuthController::class, 'ChangePassword']);
    
    Route::get('logout', [AuthController::class, 'logout']);
    
    Route::post('info', [UserController::class, 'info']);
    Route::get('states', [UserController::class, 'getStates']);
    Route::post('cities', [UserController::class, 'getCities']);

    Route::post('my_favorites',[UserController::class,'myFavorites']);

    Route::post('rating',[UserController::class,'setClientRating']);
    
    Route::post('update/image/{id}', [AuthController::class, 'update_image']);
    
    Route::post('client/list', [ClientController::class,'clientlist']);
    
    Route::post('client/details/{id}', [ClientController::class,'clientdetails']);
    
    Route::post('client/set_favorite', [ClientController::class,'setFavorite']);

    Route::post('nearet_outlets', [ClientController::class,'nearestOutlet']);

    Route::post('toprated', [ClientController::class,'topRatedClient']);

    Route::resource('update', AuthController::class);
    
    Route::post('categories/list', [CategoryController::class , 'categorieslist']);
    
    Route::post('services/list', [ServicesController::class,'serviceslist']);
    
    Route::post('amenities/list', [AmenitiesController::class,'amenitieslist']);

    Route::post('advertisment', [AdvertismentController::class,'index']);

    Route::post('add_appointment', [AppointmentController::class,'setAppointment']);

    Route::get('get_appointment', [AppointmentController::class,'getAppointment']);

    Route::post('home_outlets',[ClientController::class,'homeOutlets']);

    Route::post('client_services/{id}',[ClientController::class,'clientServices']);

    Route::post('client_categoris/{id}',[ClientController::class,'getclientcategories']);

    Route::post('timeslot',[AppointmentController::class,'timesloat']);
    
      Route::get('services-tax',[AppointmentController::class,'getServicesTax']);
      
      Route::post('globally-search',[ClientController::class,'globallySearch']);
 
});


// ***************************** Client *******************************//


Route::controller(ClientAuthController::class)->group(function(){
    Route::post('client/login', 'login');
    Route::post('client/register', 'register');
});

    Route::get('client/category-list',[ClientInfoController:: class, 'clientCategory']);
    Route::get('client/states-list',[ClientInfoController:: class, 'States']);
    Route::get('client/cities-list/{id}',[ClientInfoController:: class, 'Cities']);
    Route::get('client/amenities-list',[ClientInfoController:: class, 'amenitiesList']);
    Route::get('client/shoptime-list',[ClientInfoController:: class, 'shopTime']);
   
    
    
Route::group(['middleware' => ['auth:sanctum','ability:client']], function() {
    
    Route::get('client/logout', [ClientAuthController::class, 'logout']);
    Route::post('client/update/image/{id}', [ClientAuthController::class, 'uploadOwnerImage']);
    Route::post('client/changePassword', [ClientAuthController::class, 'ChangePassword']);
    Route::post('client/update',[ClientAuthController::class,'update']);
     Route::post('client/updateoutletinfo',[ClientAuthController::class,'updateOutletinfo']);
   
    Route::post('client/update/gumasta/{id}', [ClientAuthController::class, 'gumastaimgupload']);
    Route::post('client/update/outletimages/{id}', [ClientAuthController::class, 'outletimagesuploads']); 
     Route::post('client/update/rentAgreement/{id}',[ClientAuthController:: class, 'rentAgreement']);

     Route::get('client/info',[ClientInfoController:: class, 'clientInfo']);
    Route::post('client/get-services',[ClientServicesController:: class, 'getServices']);
     Route::post('client/add-services',[ClientServicesController:: class, 'addServices']);
    Route::get('client/client-services',[ClientServicesController:: class, 'clientServices']);
   
    Route::put('client/update-service/{id}',[ClientServicesController:: class, 'updateServices']);
    Route::delete('client/delete-service/{id}',[ClientServicesController:: class, 'deleteServices']);

    Route::get('client/holiday',[ClientHolidayController::class,'index']);
    Route::post('client/holiday/add',[ClientHolidayController::class,'store']);
    Route::put('client/holiday/update/{id}',[ClientHolidayController:: class, 'update']);
    Route::delete('client/holiday/delete/{id}',[ClientHolidayController:: class, 'destroy']); 

    Route::get('client/slot',[ClientSlotController::class,'index']);
    Route::post('client/slot/add',[ClientSlotController::class,'store']);
    Route::delete('client/slot/delete/{id}',[ClientSlotController:: class, 'destroy']); 

    Route::get('client/get-appointment',[ClientAppointmentController:: class, 'getAppointment']);
    Route::get('client/old-appointment',[ClientAppointmentController:: class, 'oldAppointment']);
    
     Route::get('client/subscription',[ClientSubscriptionController:: class, 'getsubscription']);
    

});