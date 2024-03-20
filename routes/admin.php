<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{UserController,AdminController,AdvertismentController, ClientController,CategoryController, PriceController, ServicesController,AmenityController,CityController,PageController,StateController,AppointmentController,SubscriptionController};
use App\Http\Controllers\Admin\Auth\LoginController;


Route::get('/admin', function () {
    return redirect()->route('dashboard');
})->name('admin');



Route::group(['middleware'=>'guest:admin',  'prefix' => 'admin', 'as' => 'admin.'],function(){
Route::get('/',[LoginController::class,'login_form']);
Route::get('login-form',[LoginController::class,'login_form'])->name('adminlogin.form');
Route::post('login-functionality',[LoginController::class,'login_functionality'])->name('login.functionality');
});

Route::group(['middleware'=>'auth:admin',  'prefix' => 'admin', 'as' => 'admin.'],function(){

        //login 
        Route::get('dashboard',[LoginController::class,'dashboard'])->name('dashboard'); 
        Route::get('logout',[LoginController::class,'logout'])->name('logout');


        //admin
    Route::group(['prefix' => 'admins', 'as' => 'admins.'],function(){
        Route::get('/',[AdminController::class, 'index'])->name('admins');
        Route::post('list',[AdminController::class, 'list'])->name('list');
        Route::get('create',[AdminController::class, 'add'])->name('add');
        Route::post('store',[AdminController::class, 'store'])->name('store');
        Route::get('edit/{id}',[AdminController::class, 'edit'])->name('edit');
        Route::get('update',[AdminController::class, 'update'])->name('update');
        Route::get('destroy/{id}',[AdminController::class, 'destroy'])->name('destroy');
        Route::post('saveimage',[AdminController::class, 'imageupload'])->name('saveimage');
        Route::get('profile/{id}',[AdminController::class, 'adminProfile'])->name('adminProfile');
        Route::post('profile',[AdminController::class, 'profileAdmin'])->name('profileAdmin');
        Route::post('admin_profile',[AdminController::class, 'adminProfileImage'])->name('adminProfileImage');
        Route::post('update',[AdminController::class, 'adminProfileUpdate'])->name('adminProfileUpdate');
        Route::post('edit_password',[AdminController::class, 'editPassword'])->name('editPassword');
        Route::post('update_password',[AdminController::class, 'updatePassword'])->name('updatePassword');
            
    });
        //user 

    Route::group(['prefix' => 'customer', 'as' => 'customer.'],function(){

        Route::get('/',[UserController::class, 'index'])->name('user');
        Route::post('list',[UserController::class, 'list'])->name('list');
        Route::get('add',[UserController::class, 'add'])->name('add');
        Route::post('store',[UserController::class, 'store'])->name('store');
        Route::get('edit/{id}',[UserController::class, 'edit'])->name('edit');
        Route::post('update',[UserController::class, 'update'])->name('update');
        Route::get('destroy/{id}',[UserController::class, 'destroy'])->name('destroy');
        Route::post('get-state', [UserController::class, 'userStateData'])->name('userStateData');
        Route::get('customer-favorite/{id}', [UserController::class, 'customerFavorite'])->name('customerFavorite');
        Route::get('appointment/{id}', [UserController::class, 'customerAppointment'])->name('customerAppointment');
        Route::post('appointment-list', [UserController::class, 'customerAppointmentList'])->name('customerAppointmentList');
        Route::get('appointment-details', [UserController::class, 'customerAppointmentDetails'])->name('customerAppointmentDetails');

    });

        //client

    Route::group(['prefix' => 'client', 'as' => 'client.'],function(){ 
       
        Route::get('/getClientData/{id}', [ClientController::class, 'getClientData'])->name('getclientdata');
        Route::post('get-state', [ClientController::class, 'getStateData'])->name('getStateData');
        
         Route::get('inactiveClient',[ClientController::class, 'inactiveList'])->name('inactivelist');
         
        Route::post('inactive',[ClientController::class, 'inactive_list'])->name('inactive');
         
        Route::get('/',[ClientController::class, 'index'])->name('client');
       
        Route::post('list',[ClientController::class, 'list'])->name('list');
        Route::get('add',[ClientController::class, 'add'])->name('add');
        Route::post('store',[ClientController::class, 'store'])->name('store');
        Route::get('edit/{id}',[ClientController::class, 'edit'])->name('edit');
        Route::post('update',[ClientController::class, 'update'])->name('update');
        Route::get('destory/{id}',[ClientController::class, 'destroy'])->name('destroy');
        Route::get('add-services/{id}',[ClientController::class, 'addservices'])->name('services');
        Route::post('store-services',[ClientController::class,'storeservices'])->name('storecservices');
        Route::post('services-list',[ClientController::class, 'clientServicesList'])->name('clientServicesList');
        Route::get('serices-edit/{id}',[ClientController::class, 'clientServicesEdit'])->name('clientServicesEdit');
        Route::post('serices-update',[ClientController::class, 'clientServicesUpdate'])->name('clientServicesUpdate');
        Route::get('serices-destory/{id}',[ClientController::class, 'clientServicesDestory'])->name('clientServicesDestory');
        Route::post('image-save',[ClientController::class, 'imageupload'])->name('saveimage');
        Route::post('gumasta-save',[ClientController::class, 'gumastaimgupload'])->name('gumastaimgupload');
        
        Route::post('agreement-save',[ClientController::class, 'agreementimgupload'])->name('agreementimgupload');
        
        Route::post('outlet-save',[ClientController::class, 'outletimagesupload'])->name('outletimagesupload');
        Route::post('multiple-destory',[ClientController::class, 'multipleimagedelete'])->name('multipleimagedelete');
        Route::get('details/{id}',[ClientController::class, 'clientdetails'])->name('clientdetails');
        Route::post('details',[ClientController::class, 'clientdetails'])->name('clientprofiledetail');
        Route::post('details/amenities',[ClientController::class, 'clientamenitiesdetails'])->name('clientamenitiesdetails');
        Route::post('details/profile',[ClientController::class, 'clientprofiledetails'])->name('clientprofiledetails');
        Route::post('details/services',[ClientController::class, 'clientservicesdetails'])->name('clientservicesdetails');
        Route::post('details/appointment',[ClientController::class, 'clientAppointment'])->name('clientAppointment');
        Route::post('details/appointment-list',[ClientController::class, 'clientAppointmentList'])->name('clientAppointmentList');
        Route::post('details/appointments',[ClientController::class, 'clientAppointmentListDetails'])->name('clientAppointmentListDetails');
        Route::post('details/updateprofile',[ClientController::class, 'clientupdateprofiledetails'])->name('clientupdateprofiledetails');
        Route::post('details/updateprofiledata',[ClientController::class, 'clientupdateprofiledata'])->name('clientupdateprofiledata');
          Route::post('status',[ClientController::class, 'status'])->name('status');
           Route::get('add-holidays/{id}',[ClientController::class, 'addholiday'])->name('holiday');
        Route::post('holiday-list',[ClientController::class, 'holidayLis'])->name('holidaylist');
        Route::post('store-holiday',[ClientController::class,'storeHoliday'])->name('storeholiday');
        Route::get('edit-holiday/{id}',[ClientController::class, 'editHoliday'])->name('editholiday');
        Route::post('update-holiday',[ClientController::class, 'updateholiday'])->name('updateholiday');
        Route::get('holidays-destory/{id}',[ClientController::class, 'holidayDestroy'])->name('hlidaydestroy');
        Route::get('slot/{id}',[ClientController::class, 'addslot'])->name('slot');
        Route::post('slot-availability',[ClientController::class, 'slotAvailability'])->name('availability');
        Route::post('slot-with-date',[ClientController::class, 'slotWithDate'])->name('slotWithDate');
        // Route::get('count',[ClientController::class, 'distance'])->name('distance');
    });
    
    
        //category
    Route::group(['prefix' => 'category', 'as' => 'category.'],function(){

        Route::get('/',[CategoryController::class, 'index'])->name('category');
        Route::post('list',[CategoryController::class, 'list'])->name('list');
        Route::get('add',[categoryController::class, 'create'])->name('add');
        Route::post('store',[CategoryController::class, 'store'])->name('store');
        Route::post('status',[CategoryController::class, 'status'])->name('status');
        Route::get('edit/{id}',[CategoryController::class, 'edit'])->name('edit');
        Route::post('update',[ClientController::class, 'update'])->name('update');
        Route::get('destory/{id}',[CategoryController::class, 'destroy'])->name('destroy');
        Route::post('imagesave',[CategoryController::class, 'imageupload'])->name('saveimage');
   });

      //services
    // Route::group(['prefix' => 'services', 'as' => 'services.'],function(){

        Route::get('servicers',[ServicesController::class, 'index'])->name('services.services');
        Route::post('list',[ServicesController::class, 'list'])->name('services.list');
        Route::get('add',[ServicesController::class, 'create'])->name('services.add');
        Route::post('store',[ServicesController::class, 'store'])->name('services.store');
        Route::post('status',[ServicesController::class, 'status'])->name('services.status');
        Route::get('edit/{id}',[ServicesController::class, 'edit'])->name('services.edit');
        Route::post('update',[ServicesController::class, 'update'])->name('services.update');
        Route::get('destory/{id}',[ServicesController::class, 'destroy'])->name('services.destroy');
        Route::post('imagesave',[ServicesController::class, 'imageupload'])->name('services.saveimage');
   
// });

    //amenity

    Route::group(['prefix' => 'services', 'as' => 'amenity.'],function(){

        Route::get('amenity',[AmenityController::class, 'index'])->name('amenity');
        Route::post('list',[AmenityController::class, 'list'])->name('list');
        Route::get('add',[AmenityController::class, 'create'])->name('add');
        Route::post('store',[AmenityController::class, 'store'])->name('store');
        Route::post('status',[AmenityController::class, 'status'])->name('status');
        Route::get('edit/{id}',[AmenityController::class, 'edit'])->name('edit');
        Route::post('update',[AmenityController::class, 'update'])->name('update');
        Route::get('destory/{id}',[AmenityController::class, 'destroy'])->name('destroy');
        Route::post('imagesave',[AmenityController::class, 'imageupload'])->name('saveimage');

    });

//city
    Route::group(['prefix' => 'city', 'as' => 'city.'],function(){

        Route::get('/',[CityController::class, 'index'])->name('city');
        Route::post('list',[CityController::class, 'list'])->name('list');
        Route::get('add',[CityController::class, 'add'])->name('add');
        Route::post('store',[CityController::class, 'store'])->name('store');
        Route::post('status',[CityController::class, 'status'])->name('status');
        Route::get('edit/{id}',[CityController::class, 'edit'])->name('edit');
        Route::post('update',[CityController::class, 'update'])->name('update');
        Route::get('destory/{id}',[CityController::class, 'destroy'])->name('destroy');

    });

    //state

    Route::group(['prefix' => 'state', 'as' => 'state.'],function(){
        Route::get('/',[StateController::class, 'index'])->name('state');
        Route::post('list',[StateController::class, 'list'])->name('list');
        Route::get('add',[StateController::class, 'add'])->name('add');
        Route::post('store',[StateController::class, 'store'])->name('store');
        Route::post('status',[StateController::class, 'status'])->name('status');
        Route::get('edit/{id}',[StateController::class, 'edit'])->name('edit');
        Route::post('update',[StateController::class, 'update'])->name('update');
        Route::get('destory/{id}',[StateController::class, 'destroy'])->name('destroy');
    });

//advertisment
    Route::group(['prefix' => 'advertisment', 'as' => 'advertisment.'],function(){
        
        Route::get('/',[AdvertismentController::class,'index'])->name('addvets');
        Route::post('list',[AdvertismentController::class, 'list'])->name('list');
        Route::get('add',[AdvertismentController::class, 'create'])->name('add');
        Route::post('store',[AdvertismentController::class, 'store'])->name('store');
        Route::post('imagesave',[AdvertismentController::class, 'imageupload'])->name('saveimage');
        Route::post('status',[AdvertismentController::class, 'status'])->name('status');
        Route::get('edit/{id}',[AdvertismentController::class, 'edit'])->name('edit');
        Route::post('update',[AdvertismentController::class, 'update'])->name('update');
        Route::get('destory/{id}',[AdvertismentController::class, 'destroy'])->name('destroy');
    });

    // appointment

    Route::group(['prefix' => 'appointment', 'as' => 'appointment.'],function(){

        Route::get('/',[AppointmentController::class,'index'])->name('appointment');
        Route::post('list',[AppointmentController::class,'list'])->name('list');
        Route::get('details/{id}',[AppointmentController::class,'details'])->name('details');
        Route::get('invoice/{id}',[AppointmentController::class,'invoice'])->name('invoice');
            
    });

   
    Route::group(['prefix' => 'pages', 'as' => 'pages.'],function(){

        Route::get('/',[PageController::class, 'index'])->name('pages');
        Route::post('list',[PageController::class, 'list'])->name('list');
        Route::get('add',[PageController::class, 'create'])->name('add');
        Route::post('store',[PageController::class, 'store'])->name('store');
        Route::post('status',[PageController::class, 'status'])->name('status');
        Route::get('edit/{id}',[PageController::class, 'edit'])->name('edit');
        Route::post('update',[PageController::class, 'update'])->name('update');
   });
   
   Route::group(['prefix' => 'subscription', 'as' => 'subscription.'],function(){

    Route::get('/',[SubscriptionController::class, 'index'])->name('subscription');
    // Route::post('list',[SubscriptionController::class, 'list'])->name('list');
    Route::get('add',[SubscriptionController::class, 'create'])->name('add');
    Route::post('store',[SubscriptionController::class, 'store'])->name('store');
    Route::post('status',[SubscriptionController::class, 'status'])->name('status');
    Route::post('saveimage',[SubscriptionController::class, 'imageupload'])->name('saveimage');
    Route::get('edit/{id}',[SubscriptionController::class, 'edit'])->name('edit');
    Route::post('update',[SubscriptionController::class, 'update'])->name('update');
    Route::get('destory/{id}',[SubscriptionController::class, 'destroy'])->name('destroy');

});


});