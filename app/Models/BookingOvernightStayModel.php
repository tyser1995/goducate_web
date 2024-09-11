<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingOvernightStayModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'booking_overnight_stays';

    protected $fillable =[
        'created_by_user_id',
        'customer_id',
        'room_type',
        'checkin_date',
        'checkout_date'
    ];

    public const ROOM_TYPE = [
        'courtyard_small_room'  => 'Courtyard Small Room (2 to 4 persons)',
        'family_room'           => 'Family Room (3 to 5 persons)',
        'jungle_huts'           => 'Jungle Huts (6 to 8 persons)',
        'courtyard_big_room'    => 'Courtyard Big Room (8 to 10 persons)',
        'hillside_villa'        => 'Hillside Villa (8 to 12 persons)'
    ];

    public static function createOvernightStay($data)
    {
        $payload = self::create([
            'created_by_user_id' => $data['created_by_users_id'] ?? 0,
            'customer_id' => $data['customer_id'] ?? 0,
            'room_type' => $data['room_type'],
            'checkin_date' => $data['checkin_date'],
            'checkout_date' => $data['checkout_date']
        ]);

        return $payload;
    }

    public static function getOvernightStay()
    {
        return self::get();
    }

    public static function getOvernightStayById($id)
    {
        return self::findOrFail($id);
    }

    public static function updateOvernightStay($id, $data)
    {
        $payload = self::findOrFail($id);
        
        $payload->update([
            'created_by_user_id' => $data['created_by_users_id'] ?? 0,
            'customer_id' => $data['customer_id'] ?? 0,
            'room_type' => $data['room_type'],
            'checkin_date' => $data['checkin_date'],
            'checkout_date' => $data['checkout_date']
        ]);

        return $payload;
    }

    public static function deleteOvernightStay($id)
    {
        return self::findOrFail($id)->delete();
    }
}
