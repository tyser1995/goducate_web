<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use DB;

class BookingTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'booking_transactions';

    protected $fillable =[
        'created_by_user_id',
        'customer_id',
        'name',
        'email',
        'address',
        'contact_no',
        'no_of_adults',
        'no_of_children',
        'boooking_status',
        'accomodation_id',
        'accomodation_name',
        'accomodation_taken',
        'accomodation_qty',
        'checkin_date',
        'checkout_date',
        'status'
    ];
}
