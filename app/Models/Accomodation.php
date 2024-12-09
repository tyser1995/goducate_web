<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class Accomodation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "accomodations";

    protected $fillable =[
        'created_by_user_id',
        'bookig_status',
        'type',
        'qty',
        'capacity',
        'tour_type',
        'group_type',
        'amount',
        'image',
        'description'
    ];

    public const BOOKING_STATUS = [
        '0'    => 'Overnight Stay',
        '1'    => 'Day Tour',
        '2'    => 'Place Reservation'
    ];

    public static function createAccomodation($data)
    {
        $payload = self::create([
            'created_by_user_id' => Auth::user()->id ?? 0,
            'bookig_status' => $data['bookig_status'],
            'type' => $data['type'],
            'qty' => $data['qty'],
            'capacity' => $data['capacity'],
            'tour_type' => $data['tour_type'] ?? 'NA',
            'group_type' => $data['group_type'] ?? 'NA',
            'amount' => $data['amount'] ?? '0',
            'image'         => $data['image'],
            'description'   => $data['description'] ?? ''
        ]);

        return $payload;
    }

    public static function getAccomodation()
    {
        return self::orderBy('created_at','DESC')->get();
    }

    public static function getAccomodationOvernightStay()
    {
        return self::where('bookig_status','=','0')
            ->orderBy('created_at','DESC')
            ->get();
    }

    public static function getAccomodationOvernightStayName($id)
    {
        $accomodation_id = self::where('type','=',$id)->get()->first();
        return self::findOrFail($accomodation_id->id)['type'];
    }

    public static function getAccomodationById($id)
    {
        return self::findOrFail($id);
    }

    public static function updateAccomodation($id, $data)
    {
        $payload = self::findOrFail($id);
        
        $payload->update([
            'created_by_user_id' => Auth::user()->id ?? 0,
            'bookig_status' => $data['bookig_status'],
            'type' => $data['type'],
            'qty' => $data['qty'],
            'capacity' => $data['capacity'],
            'tour_type' => $data['tour_type'] ?? 'NA',
            'group_type' => $data['group_type'] ?? 'NA',
            'amount' => $data['amount'] ?? '0',
            'image'         => $data['image'],
            'description'   => $data['description'] ?? ''
        ]);

        return $payload;
    }

    public static function deleteAccomodation($id)
    {
        return self::findOrFail($id)->delete();
    }
}
