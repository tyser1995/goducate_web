<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'bookings.customer',
        'bookings.store',
        'bookings.list',
        'bookings.overnight_stay',
        'bookings.day_tour',
        'bookings.place_reservation',
        'volunteer.register'
    ];
}
