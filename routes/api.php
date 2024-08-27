<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\App;
use App\Models\PushSubscription;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('push-subscribe', function (Request $request) {
    PushSubscription::create([
        'data' => $request->getContent(),
        'description' => '9'
    ]);
});

Route::post('push-subscribe-residents', function (Request $request) {
    $push_subscription = PushSubscription::where('created_by_users_id',$request->id)
        ->first();

        if(empty($push_subscription))
            $push_subscription = new PushSubscription();
        
        $push_subscription->data = $request->data;
        $push_subscription->created_by_users_id = $request->id;
        $push_subscription->save();
});