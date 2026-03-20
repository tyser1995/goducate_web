<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Booking Routes (public submission endpoints)
|--------------------------------------------------------------------------
*/

Route::middleware('throttle:20,1')->group(function () {
    Route::post('bookings.store', [App\Http\Controllers\BookingController::class, 'booking_store'])->name('bookings.store');
    Route::post('bookings.overnight_stay', [App\Http\Controllers\BookingController::class, 'os_store'])->name('bookings.overnight_stay');
    Route::post('bookings.day_tour', [App\Http\Controllers\BookingController::class, 'dt_store'])->name('bookings.day_tour');
    Route::post('bookings.place_reservation', [App\Http\Controllers\BookingController::class, 'pr_store'])->name('bookings.place_reservation');
});

Route::get('bookings.list', [App\Http\Controllers\BookingController::class, 'booking_list'])->name('bookings.list');
Route::get('bookings.list.table', [App\Http\Controllers\BookingController::class, 'booking_list_dashboard'])->name('bookings.list.table');
Route::get('room-capacity/{id}', [App\Http\Controllers\AccomodationController::class, 'getRoomCapacity'])->name('room-capacity');
Route::get('accomodation_list', [App\Http\Controllers\AccomodationController::class, 'getRoomCapacity'])->name('accomodation_list');
