<?php

use Illuminate\Support\Facades\Route;
use App\Models\PushSubscription;
use Illuminate\Http\Request;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/register', [App\Http\Controllers\PageController::class, 'register']);
Route::post('/user/register', ['as' => '/user/register', 'uses' => 'App\Http\Controllers\UserController@register']);
Route::get('/', [App\Http\Controllers\DashboardController::class, 'index']);//Initial Page

//About Us
Route::get('_aboutus', ['as' => '_aboutus', 'uses' => 'App\Http\Controllers\AboutUsController@aboutus_page']);

//Google
Route::get('/google/redirect', ['as' => 'google.redirect', 'uses' => 'App\Http\Controllers\Auth\LoginController@redirectToGoogle']);
Route::get('/google/callback', ['as' => 'google.callback', 'uses' => 'App\Http\Controllers\Auth\LoginController@handleGoogleCallback']);

Route::get('user/{id}/avatar', function ($id) {
    // Find the user
    $user = App\Models\User::find(1);

    // Return the image in the response with the correct MIME type
    return response()->make($user->profile_photo, 200, array(
        'Content-Type' => (new finfo(FILEINFO_MIME))->buffer($user->profile_photo)
    ));
});

Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::get('users', ['as' => 'users', 'uses' => 'App\Http\Controllers\UserController@index']);
    Route::get('users/delete/{id}', ['as' => 'users/delete/{id}', 'uses' => 'App\Http\Controllers\UserController@delete']);
    Route::get('users/verify/{id}', ['as' => 'users/verify', 'uses' => 'App\Http\Controllers\UserController@verify_user']);
	Route::resource('user', 'App\Http\Controllers\UserController');

    //User Management
    Route::get('employees', ['as' => 'employees', 'uses' => 'App\Http\Controllers\EmployeeController@index']);
    Route::get('employees/delete/{id}', ['as' => 'employees/delete/{id}', 'uses' => 'App\Http\Controllers\EmployeeController@delete']);
    Route::get('employees/data', ['as' => 'employees/data', 'uses' => 'App\Http\Controllers\EmployeeController@data']);
    Route::resource('employee','App\Http\Controllers\EmployeeController');

  	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
  	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
  	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

    Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'App\Http\Controllers\DashboardController@index']);

    //Roles
    Route::get('roles', ['as' => 'roles', 'uses' => 'App\Http\Controllers\RoleController@index']);
    Route::resource('role', 'App\Http\Controllers\RoleController');

    //About Us
  
    Route::get('aboutus', ['as' => 'aboutus', 'uses' => 'App\Http\Controllers\AboutUsController@index']);
    Route::resource('about', 'App\Http\Controllers\AboutUsController');
    
    //Announcement
    Route::get('announcements', ['as' => 'announcements', 'uses' => 'App\Http\Controllers\AnnouncementController@index']);
    Route::resource('announcement', 'App\Http\Controllers\AnnouncementController');
    
    //Price Monitoring
    Route::get('price_monitorings', ['as' => 'price_monitorings', 'uses' => 'App\Http\Controllers\PriceMonitoringController@index']);
    Route::resource('price_monitoring', 'App\Http\Controllers\PriceMonitoringController');

    //Consumer Rights
    Route::get('consumer_rights', ['as' => 'consumer_rights', 'uses' => 'App\Http\Controllers\ConsumerRightsController@index']);
    Route::get('consumer_rights/preview/{id}', ['as' => 'consumer_rights/preview', 'uses' => 'App\Http\Controllers\ConsumerRightsController@preview_page']);
    Route::resource('consumer_right', 'App\Http\Controllers\ConsumerRightsController');

    //Business Permit
    Route::get('business_permits', ['as' => 'business_permits', 'uses' => 'App\Http\Controllers\BusinessPermitController@index']);
    Route::resource('business_permit', 'App\Http\Controllers\BusinessPermitController');
    
    //Nofication
    Route::get("/admin/notify", function () {
        return view('notify', [
            'subscriptions' => PushSubscription::all()
        ]);
    });

    //POINT OF SALE
    Route::get('point_of_sales', ['as' => 'point_of_sales', 'uses' => 'App\Http\Controllers\PointOfSaleController@index']);
    Route::resource('point_of_sale', 'App\Http\Controllers\PointOfSaleController');

    Route::get('point_of_sale_items', ['as' => 'point_of_sale_items', 'uses' => 'App\Http\Controllers\PointOfSaleItemController@index']);
    Route::resource('point_of_sale_item', 'App\Http\Controllers\PointOfSaleItemController');
    Route::get('point_of_sales/types', ['as' => 'point_of_sales/types', 'uses' => 'App\Http\Controllers\PointOfSaleItemController@autocompleteTypes']);
    Route::get('point_of_sales/units', ['as' => 'point_of_sales/units', 'uses' => 'App\Http\Controllers\PointOfSaleItemController@autocompleteUnits']);
    Route::get('point_of_sales/check-item-code', ['as' => 'point_of_sales/check-item-code', 'uses' => 'App\Http\Controllers\PointOfSaleItemController@checkItemCode']);

    Route::post("incident/alert", function (PushSubscription $sub, Request $request) {
    
        $webPush = new WebPush([
            "VAPID" => [
                "publicKey" => "BC5zel9JoqeOY2yVTJjDhiE1IisJTVHq-_p4rxC3zd60gQSqXzra_7_m7B12axwI42tZIUXYGXhIJ-t5MolKjNY",
                "privateKey" => "YpOYF6OwLXH8PDW24E4Eu_kk7uOuSyApvC0NJhYNwa4",
                "subject" => "http://127.0.0.1" //mailto:exampl@gmail.com
            ]
        ]);

        
        $result = $webPush->sendOneNotification(
            Subscription::create(json_decode($sub->data ,true)),
            json_encode($request->input())
        );
    });

    Route::post("admin/sendNotif/{sub}", function (PushSubscription $sub, Request $request) {
    
        $webPush = new WebPush([
            "VAPID" => [
                "publicKey" => "BC5zel9JoqeOY2yVTJjDhiE1IisJTVHq-_p4rxC3zd60gQSqXzra_7_m7B12axwI42tZIUXYGXhIJ-t5MolKjNY",
                "privateKey" => "YpOYF6OwLXH8PDW24E4Eu_kk7uOuSyApvC0NJhYNwa4",
                "subject" => "http://127.0.0.1" //mailto:exampl@gmail.com
            ]
        ]);
        
        $result = $webPush->sendOneNotification(
            Subscription::create(json_decode($sub->data ,true)),
            json_encode($request->input())
        );
    });
});

Route::group(['middleware' => 'auth'], function () {
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);
});
