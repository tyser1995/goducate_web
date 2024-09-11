<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingPlaceReservationModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'booking_place_reservations';

    protected $fillable =[
        'created_by_user_id',
        'customer_id',
        'room_type',
        'no_of_cottages',
        'no_of_persons',
        'checkin_date',
        'checkout_date'
    ];

    public static function createPlaceReservation($data)
    {
        $payload = self::create([
            'created_by_user_id' => $data['created_by_users_id'] ?? 0,
            'customer_id' => $data['customer_id'] ?? 0,
            'room_type' => $data['room_type'],
            'no_of_cottages' => $data['no_of_cottages'],
            'no_of_persons' => $data['no_of_persons'],
            'checkin_date' => $data['checkin_date'],
            'checkout_date' => $data['checkout_date']
        ]);

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

    public static function updatePlaceReservation($id, $data)
    {
        $payload = self::findOrFail($id);
        
        $payload->update([
            'created_by_user_id' => $data['created_by_users_id'] ?? 0,
            'customer_id' => $data['customer_id'] ?? 0,
            'room_type' => $data['room_type'],
            'no_of_cottages' => $data['no_of_cottages'],
            'no_of_persons' => $data['no_of_persons'],
            'checkin_date' => $data['checkin_date'],
            'checkout_date' => $data['checkout_date']
        ]);

        return $payload;
    }

    public static function deletePlaceReservation($id)
    {
        return self::findOrFail($id)->delete();
    }
}
