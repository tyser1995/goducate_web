<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (no auth required)
|--------------------------------------------------------------------------
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('_booking', [App\Http\Controllers\HomeController::class, 'booking']);
Route::get('/get-room-details/{id}', [App\Http\Controllers\HomeController::class, 'getRoomDetails']);

// Registration (rate-limited)
Route::get('/register', [App\Http\Controllers\PageController::class, 'register']);
Route::post('/user/register', [App\Http\Controllers\UserController::class, 'register'])
    ->middleware('throttle:5,1')
    ->name('user.register');

// About / Activities / Volunteer / Survey
Route::get('_aboutus', [App\Http\Controllers\AboutUsController::class, 'aboutus_page'])->name('_aboutus');
Route::get('_activities', [App\Http\Controllers\ActivityPageController::class, 'activity_page'])->name('_activities');
Route::get('_activities_page/{id}', [App\Http\Controllers\ActivityPageController::class, 'activity_page_id'])->name('_activities_page');

Route::get('_volunteer', [App\Http\Controllers\VolunteerController::class, 'volunteer_page'])->name('_volunteer');
Route::post('volunteer.register', [App\Http\Controllers\VolunteerController::class, 'register'])
    ->middleware('throttle:10,1')
    ->name('volunteer.register');

Route::get('_survey', [App\Http\Controllers\SurveyController::class, 'survey_page'])->name('_survey');
Route::post('survey.register', [App\Http\Controllers\SurveyController::class, 'register'])
    ->middleware('throttle:10,1')
    ->name('survey.register');

Route::get('_feedback', [App\Http\Controllers\SurveyController::class, 'feedback_page'])->name('_feedback');
Route::post('survey.feedback', [App\Http\Controllers\SurveyController::class, 'feedback'])
    ->middleware('throttle:10,1')
    ->name('survey.feedback');

// Google OAuth
Route::get('/google/redirect', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/google/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleGoogleCallback'])->name('google.callback');

// QR Code (public verify)
Route::get('qr.code', [App\Http\Controllers\QRCodeController::class, 'generateQRCode'])->name('qr.code');
Route::get('download-code', [App\Http\Controllers\QRCodeController::class, 'downloadQrCode'])->name('download-code');
Route::post('verify-code', [App\Http\Controllers\QRCodeController::class, 'verifyQRCode'])
    ->middleware('throttle:20,1')
    ->name('verify-code');

// Stripe Checkout
Route::get('checkout/{id}', [App\Http\Controllers\TransactionController::class, 'showCheckoutForm'])->name('checkout');
Route::post('checkout.process', [App\Http\Controllers\TransactionController::class, 'processPayment'])
    ->middleware('throttle:10,1')
    ->name('checkout.process');

// User avatar
Route::get('user/{id}/avatar', function ($id) {
    $user = App\Models\User::findOrFail($id);
    $finfo = new finfo(FILEINFO_MIME);
    return response()->make($user->profile_photo, 200, [
        'Content-Type' => $finfo->buffer($user->profile_photo),
    ]);
});

Auth::routes();

// Fallback page catch-all (must stay last, auth-gated)
Route::group(['middleware' => 'auth'], function () {
    Route::get('{page}', [App\Http\Controllers\PageController::class, 'index'])->name('page.index');
});
