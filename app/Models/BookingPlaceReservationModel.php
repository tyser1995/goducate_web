<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;

class BookingPlaceReservationModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'booking_place_reservations';

    protected $fillable =[
        'created_by_user_id',
        'customer_id',
        'email',
        'room_type',
        'no_of_cottages',
        'no_of_persons',
        'checkin_date',
        'checkout_date',
        'status'
    ];

    public const ROOM_TYPE = [
        'board_room'        => 'Board Room',
        'function_hall'     => 'Function Hall',
        'basketball_gym'    => 'Basketball Gym',
        'cottages'          => 'Cottages',
        'small_huts'        => 'Small Huts'
    ];

    public static function createPlaceReservation($data)
    {
        $payload = self::create([
            'created_by_user_id' => $data['created_by_users_id'] ?? 0,
            'customer_id' => $data['customer_id'] ?? 0,
            'email' => $data['email'],
            'room_type' => $data['room_type'],
            'no_of_cottages' => $data['no_of_cottages'] ?? 0,
            'no_of_persons' => $data['no_of_persons'] ?? 0,
            'checkin_date' => $data['checkin_date'],
            'checkout_date' => $data['checkout_date'],
            'status' => 'pending'
        ]);

        $emailDetails = [
            'title' => 'Reservation Confirmation',
            'body' => 'Your reservation details have been saved. Kindly check your email for the confirmation of your request. Thank you for choosing Goducate!',
            'reservation' => $payload, 
            'booking_status' => 'place_reservation'
        ];
    
        Mail::to($data['email'])->send(new \App\Mail\SendMail($emailDetails));
        return $payload;
    }

    public static function getPlaceReservation()
    {
        return self::get();
    }

    public static function getPlaceReservationById($id)
    {
        return self::findOrFail($id);
    }

    public static function getPlaceReservationByEmail($email,$IsBook=true)
    {
        if($IsBook){
            return self::where('email','=',$email)
            ->where('status','=','pending')
            ->get();
        }else{
            return self::where('email','=',$email)
            ->get();
        }
        
    }

    public static function updatePlaceReservation($id, $data)
    {
        $payload = self::findOrFail($id);
        
        $payload->update([
            'created_by_user_id' => $data['created_by_users_id'] ?? 0,
            'customer_id' => $data['customer_id'] ?? 0,
            'email' => $data['email'],
            'room_type' => $data['room_type'],
            'no_of_cottages' => $data['no_of_cottages'] ?? 0,
            'no_of_persons' => $data['no_of_persons'] ?? 0,
            'checkin_date' => $data['checkin_date'],
            'checkout_date' => $data['checkout_date']
        ]);

        return $payload;
    }

    public static function updatePlaceReservationStatus($email, $data)
    {
        $payload = self::where('email', '=', $email)
        ->where('status','pending')
        ->get();
    
        if ($payload->isNotEmpty()) {
            foreach ($payload as $record) {
                $record->update([
                    'status' => $data['status']
                ]);
            }
        }

        return $payload;
    }
    

    public static function deletePlaceReservation($id)
    {
        return self::findOrFail($id)->delete();
    }
}
