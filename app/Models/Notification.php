<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;

class Notification extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'notifications';

    protected $fillable =[
        'created_by_user_id',
        'customer_id',
        'type',
        'status'
    ];

    public static function createNotification($data)
    {
        return self::create([
            'created_by_user_id' => Auth::user()->id ?? 0,
            'customer_id' => $data['customer_id'] ?? 0,
            'type' => $data['type'] ?? '',
            'status' => $data['status'] ?? ''
        ]);
    }

    public static function getNotificationByCustomerId($customer_id)
    {

        return self::where('customer_id','=',$customer_id)
        ->get();
    }

    public static function getNotificationById($id)
    {
        return self::findOrFail($id);
    }

    public static function getNotificationPartialOnly()
    {
        return self::where('status','=','pending')
        ->orderBy('created_at','DESC')
        ->get();
    }

    public static function updateNotification($id, $data)
    {
        $payload = self::findOrFail($id);
        
        $payload->update([
            'created_by_user_id' => Auth::user()->id ?? 0,
            'customer_id' => $data['customer_id'] ?? 0,
            'type' => $data['type'] ?? '',
            'status' => $data['status'] ?? ''
        ]);

        return $payload;
    }

    public static function updateNotificationStatus($customer_id,$type)
    {
        $payload = self::where('customer_id','=',$customer_id)
        ->where('type','=',$type);
        
        $payload->update([
            'created_by_user_id' => Auth::user()->id ?? 0,
            'status' => 'Viewed by '.Auth::user()->name
        ]);

        return $payload;
    }

    public static function deleteNotification($id)
    {
        return self::findOrFail($id)->delete();
    }
}
