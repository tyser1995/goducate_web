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
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);//Initial Page
Route::get('/register', [App\Http\Controllers\PageController::class, 'register']);
Route::post('/user/register', ['as' => '/user/register', 'uses' => 'App\Http\Controllers\UserController@register']);

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index']);//Initial Page

//About Us
Route::get('_aboutus', ['as' => '_aboutus', 'uses' => 'App\Http\Controllers\AboutUsController@aboutus_page']);
//Activity
Route::get('_activities', ['as' => '_activities', 'uses' => 'App\Http\Controllers\ActivityPageController@activity_page']);
Route::get('_activities_page/{id}', ['as' => '_activities_page', 'uses' => 'App\Http\Controllers\ActivityPageController@activity_page_id']);
//Volunteer
Route::get('_volunteer', ['as' => '_volunteer', 'uses' => 'App\Http\Controllers\VolunteerController@volunteer_page']);
Route::post('volunteer.register', ['as' => 'volunteer.register', 'uses' => 'App\Http\Controllers\VolunteerController@register']);

//Survey and Feedback
Route::get('_survey', ['as' => '_survey', 'uses' => 'App\Http\Controllers\SurveyController@survey_page']);
Route::post('survey.register', ['as' => 'survey.register', 'uses' => 'App\Http\Controllers\SurveyController@register']);

Route::get('_feedback', ['as' => '_feedback', 'uses' => 'App\Http\Controllers\SurveyController@feedback_page']);
Route::post('survey.feedback', ['as' => 'survey.feedback', 'uses' => 'App\Http\Controllers\SurveyController@feedback']);


//
Route::get('_booking', [App\Http\Controllers\HomeController::class, 'booking']);

//Booking public
Route::post('bookings.store', ['as' => 'bookings.store', 'uses' => 'App\Http\Controllers\BookingController@booking_store']);
Route::get('bookings.list', ['as' => 'bookings.list', 'uses' => 'App\Http\Controllers\BookingController@booking_list']);
Route::get('bookings.list.table', ['as' => 'bookings.list.table', 'uses' => 'App\Http\Controllers\BookingController@booking_list_dashboard']);
Route::post('bookings.overnight_stay', ['as' => 'bookings.overnight_stay', 'uses' => 'App\Http\Controllers\BookingController@os_store']);
Route::post('bookings.day_tour', ['as' => 'bookings.day_tour', 'uses' => 'App\Http\Controllers\BookingController@dt_store']);
Route::post('bookings.place_reservation', ['as' => 'bookings.place_reservation', 'uses' => 'App\Http\Controllers\BookingController@pr_store']);
Route::get('room-capacity/{id}', ['as' => 'room-capacity/{id}', 'uses' => 'App\Http\Controllers\AccomodationController@getRoomCapacity']);
Route::get('accomodation_list', ['as' => 'accomodation_list', 'uses' => 'App\Http\Controllers\AccomodationController@getRoomCapacity']);
// Route::resource('booking', 'App\Http\Controllers\BookingController');

//Google
Route::get('/google/redirect', ['as' => 'google.redirect', 'uses' => 'App\Http\Controllers\Auth\LoginController@redirectToGoogle']);
Route::get('/google/callback', ['as' => 'google.callback', 'uses' => 'App\Http\Controllers\Auth\LoginController@handleGoogleCallback']);

//QR Code
Route::get('qr.code', ['as' => 'qr.code', 'uses' => 'App\Http\Controllers\QRCodeController@generateQRCode']);
Route::get('download-code', ['as' => 'download-code', 'uses' => 'App\Http\Controllers\QRCodeController@downloadQrCode']);
Route::post('verify-code', ['as' => 'verify-code', 'uses' => 'App\Http\Controllers\QRCodeController@verifyQRCode']);


//Stripe Payment
Route::get('checkout/{id}', ['as' => 'checkout/{id}', 'uses' => 'App\Http\Controllers\TransactionController@showCheckoutForm']);
Route::post('checkout.process', ['as' => 'checkout.process', 'uses' => 'App\Http\Controllers\TransactionController@processPayment']);


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

    //Activities
    Route::get('activities', ['as' => 'activities', 'uses' => 'App\Http\Controllers\ActivityPageController@index']);
    //List
    Route::get('activities/create/list', ['as' => 'activities/create/list', 'uses' => 'App\Http\Controllers\ActivityPageController@create_list']);
    Route::post('activities/store/list', ['as' => 'activities/store/list', 'uses' => 'App\Http\Controllers\ActivityPageController@store_list']);
    Route::get('activities/edit/list/{id}', ['as' => 'activities.edit.list', 'uses' => 'App\Http\Controllers\ActivityPageController@edit_list']);
    Route::put('activities/update/list/{id}', ['as' => 'activities.update.list', 'uses' => 'App\Http\Controllers\ActivityPageController@update_list']);
    Route::delete('activities/delete/list/{id}', ['as' => 'activities.delete.list', 'uses' => 'App\Http\Controllers\ActivityPageController@destroy_list']);

    Route::resource('activity', 'App\Http\Controllers\ActivityPageController');

    //Booking
    Route::get('bookings', ['as' => 'bookings', 'uses' => 'App\Http\Controllers\BookingController@index']);
    Route::resource('booking', 'App\Http\Controllers\BookingController');

    //Volunteer
    Route::get('volunteers.verify/{id}', ['as' => 'volunteers.verify', 'uses' => 'App\Http\Controllers\VolunteerController@verify_volunteer']);
    Route::post('volunteers.bulk.approve', ['as' => 'volunteers.bulk.approve', 'uses' => 'App\Http\Controllers\VolunteerController@approve_volunteer']);
    Route::post('volunteers.bulk.disapprove', ['as' => 'volunteers.bulk.disapprove', 'uses' => 'App\Http\Controllers\VolunteerController@disapprove_volunteer']);
    Route::get('volunteers', ['as' => 'volunteers', 'uses' => 'App\Http\Controllers\VolunteerController@index']);
    Route::resource('volunteer', 'App\Http\Controllers\VolunteerController');

    //Customer
    Route::get('customers', ['as' => 'customers', 'uses' => 'App\Http\Controllers\CustomerController@index']);
    Route::get('customer.generate_qrcode/{id}', ['as' => 'customer.generate_qrcode', 'uses' => 'App\Http\Controllers\CustomerController@generateQrCode']);
    Route::get('customer.payment/{id}', ['as' => 'customer.payment', 'uses' => 'App\Http\Controllers\CustomerController@getPayments']);
    Route::get('customer.payment.verify/{id}', ['as' => 'customer.payment.verify', 'uses' => 'App\Http\Controllers\CustomerController@getVerifyPayments']);
    Route::post('customer.payment.store', ['as' => 'customer.payment.store', 'uses' => 'App\Http\Controllers\CustomerController@addPayments']);
    Route::post('transaction.delete', ['as' => 'transaction.delete', 'uses' => 'App\Http\Controllers\CustomerController@getCustomerPrintAndDelete']);
    Route::resource('customer', 'App\Http\Controllers\CustomerController');

    //QR Code Generator
    Route::get('qrcodes', ['as' => 'qrcodes', 'uses' => 'App\Http\Controllers\QRCodeController@index']);
    Route::post('generate-code',['as' => 'generate-code', 'uses' => 'App\Http\Controllers\QRCodeController@_generateQRCode']);
    Route::post('funds.update',['as' => 'funds.update', 'uses' => 'App\Http\Controllers\QRCodeController@updateFunds']);
    Route::resource('qrcode', 'App\Http\Controllers\QRCodeController');

    //Survey
    Route::get('surveys', ['as' => 'surveys', 'uses' => 'App\Http\Controllers\SurveyController@index']);
    Route::get('feedbacks', ['as' => 'feedbacks', 'uses' => 'App\Http\Controllers\SurveyController@index_feedback']);
    Route::get('surveys.list', ['as' => 'surveys.list', 'uses' => 'App\Http\Controllers\SurveyController@survey_data']);
    Route::get('feedback.list', ['as' => 'feedback.list', 'uses' => 'App\Http\Controllers\SurveyController@feedback_data']);
    Route::resource('survey', 'App\Http\Controllers\SurveyController');

    //Announcement
    Route::get('announcements', ['as' => 'announcements', 'uses' => 'App\Http\Controllers\AnnouncementController@index']);
    Route::resource('announcement', 'App\Http\Controllers\AnnouncementController');

    //Accomodation
    Route::get('accomodations', ['as' => 'accomodations', 'uses' => 'App\Http\Controllers\AccomodationController@index']);
    Route::resource('accomodation', 'App\Http\Controllers\AccomodationController');

    //Report
    Route::get('reports', ['as' => 'reports', 'uses' => 'App\Http\Controllers\ReportController@index']);
    Route::get('chart.data.activity', ['as' => 'chart.data.activity', 'uses' => 'App\Http\Controllers\ReportController@getChartDataActivity']);
    Route::get('chart.data.demographic', ['as' => 'chart.data.demographic', 'uses' => 'App\Http\Controllers\ReportController@getChartDataDemographic']);
    Route::get('chart.data.booking', ['as' => 'chart.data.booking', 'uses' => 'App\Http\Controllers\ReportController@getChartDataBooking']);
    Route::get('chart.data.feedback', ['as' => 'chart.data.feedback', 'uses' => 'App\Http\Controllers\ReportController@getChartDataFeedback']);

    Route::resource('report', 'App\Http\Controllers\ReportController');
    
    //Price Monitoring
    Route::get('price_monitorings', ['as' => 'price_monitorings', 'uses' => 'App\Http\Controllers\PriceMonitoringController@index']);
    Route::resource('price_monitoring', 'App\Http\Controllers\PriceMonitoringController');
    
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
