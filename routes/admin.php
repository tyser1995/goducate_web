<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin / Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::get('users', [App\Http\Controllers\UserController::class, 'index'])->name('users');
    Route::get('users/delete/{id}', [App\Http\Controllers\UserController::class, 'delete'])->name('users.delete');
    Route::get('users/verify/{id}', [App\Http\Controllers\UserController::class, 'verify_user'])->name('users.verify');
    Route::resource('user', App\Http\Controllers\UserController::class);

    // Employees
    Route::get('employees', [App\Http\Controllers\EmployeeController::class, 'index'])->name('employees');
    Route::get('employees/delete/{id}', [App\Http\Controllers\EmployeeController::class, 'delete'])->name('employees.delete');
    Route::get('employees/data', [App\Http\Controllers\EmployeeController::class, 'data'])->name('employees.data');
    Route::resource('employee', App\Http\Controllers\EmployeeController::class);

    // Profile
    Route::get('profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [App\Http\Controllers\ProfileController::class, 'password'])->name('profile.password');

    // Roles
    Route::get('roles', [App\Http\Controllers\RoleController::class, 'index'])->name('roles');
    Route::resource('role', App\Http\Controllers\RoleController::class);

    // About Us
    Route::get('aboutus', [App\Http\Controllers\AboutUsController::class, 'index'])->name('aboutus');
    Route::resource('about', App\Http\Controllers\AboutUsController::class);

    // Activities
    Route::get('activities', [App\Http\Controllers\ActivityPageController::class, 'index'])->name('activities');
    Route::get('activities/create/list', [App\Http\Controllers\ActivityPageController::class, 'create_list'])->name('activities.create.list');
    Route::post('activities/store/list', [App\Http\Controllers\ActivityPageController::class, 'store_list'])->name('activities.store.list');
    Route::get('activities/edit/list/{id}', [App\Http\Controllers\ActivityPageController::class, 'edit_list'])->name('activities.edit.list');
    Route::put('activities/update/list/{id}', [App\Http\Controllers\ActivityPageController::class, 'update_list'])->name('activities.update.list');
    Route::delete('activities/delete/list/{id}', [App\Http\Controllers\ActivityPageController::class, 'destroy_list'])->name('activities.delete.list');
    Route::resource('activity', App\Http\Controllers\ActivityPageController::class);

    // Bookings (admin management)
    Route::get('bookings', [App\Http\Controllers\BookingController::class, 'index'])->name('bookings');
    Route::resource('booking', App\Http\Controllers\BookingController::class);

    // Volunteers
    Route::get('volunteers', [App\Http\Controllers\VolunteerController::class, 'index'])->name('volunteers');
    Route::get('volunteers.verify/{id}', [App\Http\Controllers\VolunteerController::class, 'verify_volunteer'])->name('volunteers.verify');
    Route::post('volunteers.bulk.approve', [App\Http\Controllers\VolunteerController::class, 'approve_volunteer'])->name('volunteers.bulk.approve');
    Route::post('volunteers.bulk.disapprove', [App\Http\Controllers\VolunteerController::class, 'disapprove_volunteer'])->name('volunteers.bulk.disapprove');
    Route::resource('volunteer', App\Http\Controllers\VolunteerController::class);

    // Customers & Payments
    Route::get('customers', [App\Http\Controllers\CustomerController::class, 'index'])->name('customers');
    Route::get('customer.generate_qrcode/{id}', [App\Http\Controllers\CustomerController::class, 'generateQrCode'])->name('customer.generate_qrcode');
    Route::get('customer.payment/{id}', [App\Http\Controllers\CustomerController::class, 'getPayments'])->name('customer.payment');
    Route::get('customer.payment.verify/{id}', [App\Http\Controllers\CustomerController::class, 'getVerifyPayments'])->name('customer.payment.verify');
    Route::post('customer.payment.store', [App\Http\Controllers\CustomerController::class, 'addPayments'])
        ->middleware('throttle:20,1')
        ->name('customer.payment.store');
    Route::post('transaction.delete', [App\Http\Controllers\CustomerController::class, 'getCustomerPrintAndDelete'])->name('transaction.delete');
    Route::resource('customer', App\Http\Controllers\CustomerController::class);

    // QR Codes
    Route::get('qrcodes', [App\Http\Controllers\QRCodeController::class, 'index'])->name('qrcodes');
    Route::post('generate-code', [App\Http\Controllers\QRCodeController::class, '_generateQRCode'])->name('generate-code');
    Route::post('funds.update', [App\Http\Controllers\QRCodeController::class, 'updateFunds'])->name('funds.update');
    Route::resource('qrcode', App\Http\Controllers\QRCodeController::class);

    // Surveys & Feedback
    Route::get('surveys', [App\Http\Controllers\SurveyController::class, 'index'])->name('surveys');
    Route::get('feedbacks', [App\Http\Controllers\SurveyController::class, 'index_feedback'])->name('feedbacks');
    Route::get('surveys.list', [App\Http\Controllers\SurveyController::class, 'survey_data'])->name('surveys.list');
    Route::get('feedback.list', [App\Http\Controllers\SurveyController::class, 'feedback_data'])->name('feedback.list');
    Route::resource('survey', App\Http\Controllers\SurveyController::class);

    // Announcements
    Route::get('announcements', [App\Http\Controllers\AnnouncementController::class, 'index'])->name('announcements');
    Route::resource('announcement', App\Http\Controllers\AnnouncementController::class);

    // Accommodations
    Route::get('accomodations', [App\Http\Controllers\AccomodationController::class, 'index'])->name('accomodations');
    Route::resource('accomodation', App\Http\Controllers\AccomodationController::class);

    // Reports
    Route::get('reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports');
    Route::get('chart.data.activity', [App\Http\Controllers\ReportController::class, 'getChartDataActivity'])->name('chart.data.activity');
    Route::get('chart.data.demographic', [App\Http\Controllers\ReportController::class, 'getChartDataDemographic'])->name('chart.data.demographic');
    Route::get('chart.data.booking', [App\Http\Controllers\ReportController::class, 'getChartDataBooking'])->name('chart.data.booking');
    Route::get('chart.data.feedback', [App\Http\Controllers\ReportController::class, 'getChartDataFeedback'])->name('chart.data.feedback');
    Route::resource('report', App\Http\Controllers\ReportController::class);

    // Price Monitoring
    Route::get('price_monitorings', [App\Http\Controllers\PriceMonitoringController::class, 'index'])->name('price_monitorings');
    Route::resource('price_monitoring', App\Http\Controllers\PriceMonitoringController::class);

    // Point of Sale
    Route::get('point_of_sales', [App\Http\Controllers\PointOfSaleController::class, 'index'])->name('point_of_sales');
    Route::resource('point_of_sale', App\Http\Controllers\PointOfSaleController::class);
    Route::get('point_of_sale_items', [App\Http\Controllers\PointOfSaleItemController::class, 'index'])->name('point_of_sale_items');
    Route::resource('point_of_sale_item', App\Http\Controllers\PointOfSaleItemController::class);
    Route::get('point_of_sales/types', [App\Http\Controllers\PointOfSaleItemController::class, 'autocompleteTypes'])->name('point_of_sales.types');
    Route::get('point_of_sales/units', [App\Http\Controllers\PointOfSaleItemController::class, 'autocompleteUnits'])->name('point_of_sales.units');
    Route::get('point_of_sales/check-item-code', [App\Http\Controllers\PointOfSaleItemController::class, 'checkItemCode'])->name('point_of_sales.check-item-code');

    // Push Notifications
    Route::get('/admin/notify', [App\Http\Controllers\NotificationController::class, 'index'])->name('admin.notify');
    Route::post('incident/alert', [App\Http\Controllers\NotificationController::class, 'sendAlert'])->name('incident.alert');
    Route::post('admin/sendNotif/{sub}', [App\Http\Controllers\NotificationController::class, 'sendToSubscriber'])->name('admin.sendNotif');
    Route::post('admin/broadcast', [App\Http\Controllers\NotificationController::class, 'broadcast'])->name('admin.broadcast');
});
