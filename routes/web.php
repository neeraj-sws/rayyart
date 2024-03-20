<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ClientauthController,MailController};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/optimize', function () {
    try{
    \Artisan::call('cache:clear');
    \Artisan::call('route:clear');
    \Artisan::call('config:clear');
    \Artisan::call('view:clear');
    \Artisan::call('route:cache');
    \Artisan::call('optimize');
    }catch(\Exception $e){
    }

});


Route::get('send-mail', [MailController::class, 'index']);

// Route::get('/', [App\Http\Controllers\Front\Auth\LoginController::class, 'showLoginForm']);

Route::get('/', [App\Http\Controllers\Front\HomeController::class, 'index'])->name('home');



Route::get('login',[App\Http\Controllers\Front\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login',[App\Http\Controllers\Front\Auth\LoginController::class, 'login'])->name('submit.login');
Route::post('logout',[App\Http\Controllers\Front\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('register',[App\Http\Controllers\Front\Auth\RegisterController::class, 'showRegistrationForm']);
Route::post('register',[App\Http\Controllers\Front\Auth\RegisterController::class, 'register'])->name('register');




Route::get('login-form',[ClientauthController::class,'login_form'])->name('clientlogin.form');
Route::post('login-client',[ClientauthController::class,'login_functionality'])->name('login.client');

Route::group(['middleware'=>'client'],function(){
    Route::get('logout',[ClientauthController::class,'logout'])->name('clientlogout');
    Route::get('dashboard',[ClientauthController::class,'dashboard'])->name('dashboard');
});


Route::get('about-us', [App\Http\Controllers\Front\HomeController::class, 'about_us'])->name('about-us');
Route::get('terms-condition', [App\Http\Controllers\Front\HomeController::class, 'term_condition'])->name('terms-condition');
Route::get('privacy-policy', [App\Http\Controllers\Front\HomeController::class, 'privacy_policy'])->name('privacy-policy');


// Route::get('login-form',[AdminController::class,'login_form'])->name('login.form');
// Route::post('login-functionality',[AdminController::class,'login_functionality'])->name('login.functionality');

// Route::group(['middleware'=>'admin'],function(){
//     Route::get('logout',[AdminController::class,'logout'])->name('admin.logout');
//     Route::get('dashboard',[AdminController::class,'dashboard'])->name('dashboard');
// });