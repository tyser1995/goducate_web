<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use App\Models\CustomerModel;

use DB;

class BookingModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bookings';

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
        'status'
    ];

    // protected $attributes = [
    //     'created_by_user_id' => 0, 
    //     'customer_id' => 0,
    //     'name' => 'Guest',
    //     'email' => 'no-reply@example.com',
    //     'address' => '',
    //     'contact_no' => '',
    //     'no_of_adults' => 1,
    //     'no_of_children' => 0,
    //     'booking_status' => '',
    // ];

    public static function createBooking($data)
    {
        $payload = self::create([
            'created_by_user_id' => $data['created_by_users_id'] ?? 0,
            'customer_id' => $data['customer_id'] ?? 0,
            'name' => $data['name'],
            'email' => $data['email'],
            'address' => $data['address'],
            'contact_no' => $data['contact_no'],
            'no_of_adults' => $data['no_of_adults'],
            'no_of_children' => $data['no_of_children'],
            'boooking_status' => $data['boooking_status'],
            'status' => 'pending'
        ]);

        return $payload;
    }

    public static function getBookingList()
    {
        return self::selectRaw("
                bookings.id,
                bookings.name,
                bookings.email,
                bookings.address,
                bookings.contact_no,
                bookings.status,
                CASE 
                    WHEN bookings.boooking_status = 0 THEN booking_overnight_stays.checkin_date 
                    WHEN bookings.boooking_status = 1 THEN booking_day_tours.checkin_date 
                    ELSE booking_place_reservations.checkin_date 
                END as checkin_date,
                CASE 
                    WHEN bookings.boooking_status = 0 THEN booking_overnight_stays.checkout_date 
                    WHEN bookings.boooking_status = 1 THEN booking_day_tours.checkout_date 
                    ELSE booking_place_reservations.checkout_date 
                END as checkout_date,
                bookings.created_at
            ")
            ->leftJoin('booking_overnight_stays', function($join) {
                $join->on('booking_overnight_stays.email', '=', 'bookings.email')
                    ->where('bookings.boooking_status', '=', 0);
            })
            ->leftJoin('booking_day_tours', function($join) {
                $join->on('booking_day_tours.email', '=', 'bookings.email')
                    ->where('bookings.boooking_status', '=', 1); 
            })
            ->leftJoin('booking_place_reservations', function($join) {
                $join->on('booking_place_reservations.email', '=', 'bookings.email')
                    ->where('bookings.boooking_status', '!=', 2);
            })
            ->distinct()
            ->orderBy('bookings.created_at','DESC')
            ->get();
    }

    public static function getBookingListTable()
    {
        return self::selectRaw("
                bookings.id,
                bookings.name,
                bookings.email,
                bookings.address,
                '' as 'status',
                bookings.contact_no,
                CASE 
                    WHEN bookings.boooking_status = 0 THEN booking_overnight_stays.checkin_date 
                    WHEN bookings.boooking_status = 1 THEN booking_day_tours.checkin_date 
                    ELSE booking_place_reservations.checkin_date 
                END as checkin_date,
                CASE 
                    WHEN bookings.boooking_status = 0 THEN booking_overnight_stays.checkout_date 
                    WHEN bookings.boooking_status = 1 THEN booking_day_tours.checkout_date 
                    ELSE booking_place_reservations.checkout_date 
                END as checkout_date,
                bookings.created_at
            ")
            ->leftJoin('booking_overnight_stays', function($join) {
                $join->on('booking_overnight_stays.email', '=', 'bookings.email')
                    ->where('bookings.boooking_status', '=', 0);
            })
            ->leftJoin('booking_day_tours', function($join) {
                $join->on('booking_day_tours.email', '=', 'bookings.email')
                    ->where('bookings.boooking_status', '=', 1); 
            })
            ->leftJoin('booking_place_reservations', function($join) {
                $join->on('booking_place_reservations.email', '=', 'bookings.email')
                    ->where('bookings.boooking_status', '=', 2);
            })
            ->orderBy('bookings.created_at','DESC')
            ->get();
    }

    public static function getBooking()
    {
        return self::selectRaw("
                CASE 
                    WHEN bookings.boooking_status = 0 THEN booking_overnight_stays.checkin_date 
                    WHEN bookings.boooking_status = 1 THEN booking_day_tours.checkin_date 
                    ELSE booking_place_reservations.checkin_date 
                END as checkin_date,
                CASE 
                    WHEN bookings.boooking_status = 0 THEN booking_overnight_stays.checkout_date 
                    WHEN bookings.boooking_status = 1 THEN booking_day_tours.checkout_date 
                    ELSE booking_place_reservations.checkout_date 
                END as checkout_date
            ")
            ->leftJoin('booking_overnight_stays', function($join) {
                $join->on('booking_overnight_stays.customer_id', '=', 'bookings.customer_id')
                    ->where('bookings.boooking_status', '=', 0);
            })
            ->leftJoin('booking_day_tours', function($join) {
                $join->on('booking_day_tours.customer_id', '=', 'bookings.customer_id')
                    ->where('bookings.boooking_status', '=', 1); 
            })
            ->leftJoin('booking_place_reservations', function($join) {
                $join->on('booking_place_reservations.customer_id', '=', 'bookings.customer_id')
                    ->where('bookings.boooking_status', '!=', 0)
                    ->where('bookings.boooking_status', '!=', 1); 
            })
            ->distinct()
            ->get();
    }

    public static function getBookingById($id)
    {
        return self::findOrFail($id);
    }

    public static function getBookingByEmail($email)
    {
        return self::where('email','=',$email)
        ->orderBy('created_at','DESC')
        ->get();
    }

    public static function updateBooking($id, $data)
    {
        $payload = self::findOrFail($id);
        
        $payload->update([
            'created_by_user_id' => $data['created_by_users_id'] ?? 0,
            'customer_id' => $data['customer_id'] ?? 0,
            'name' => $data['name'],
            'email' => $data['email'],
            'address' => $data['address'],
            'contact_no' => $data['contact_no'],
            'no_of_adults' => $data['no_of_adults'],
            'no_of_children' => $data['no_of_children'],
            'boooking_status' => $data['boooking_status']
        ]);

        $emailDetails = [
            'title' => 'Reservation Confirmation',
            'body' => 'Your reservation details have been saved. Kindly check your email for the confirmation of your request. Thank you for choosing Goducate!',
            'reservation' => $payload, 
            'booking_status' => $data['boooking_status']
        ];
    
        Mail::to($data['email'])->send(new \App\Mail\SendMail($emailDetails));

        return $payload;
    }

    public static function updateBookingStatus($id, $data)
    {
        $payload = self::findOrFail($id);
        
        $payload->update([
            'status' => $data['status']
        ]);
        
        CustomerModel::create([
            'created_by_user_id' => Auth::user()->id ?? 0,
            'first_name' => $payload->name ?? '',
            'middle_name' => '',
            'last_name' =>  '',
            'email' => $payload->email,
            'address' => '',
            'contact_no' => 0
        ]);

        // $emailDetails = [
        //     'title' => 'Reservation Approved',
        //     'body' => 'Your reservation details have been saved. Kindly check your email for the confirmation of your request. Thank you for choosing Goducate!',
        //     'reservation' => $payload, 
        //     'booking_status' => $payload['boooking_status']
        // ];
    
        // Mail::to($payload['email'])->send(new \App\Mail\SendMail($emailDetails));

        return $payload;
    }

    public static function deleteBooking($id)
    {
        return self::findOrFail($id)->delete();
    }
}
