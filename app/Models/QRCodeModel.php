<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class QRCodeModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'qrcodes';

    protected $fillable =[
        'created_by_user_id',
        'qrcode_number',
        'amount',
        'qrcode_generated'
    ];

    public static function createQRCode($data)
    {
        $payload = self::create([
            'created_by_user_id' => Auth::user()->id,
            'qrcode_number' => $data['number'] ?? '',
            'amount' => $data['amount'] ?? 75,
            'qrcode_generated' => $data['qrcode_generated'] ?? ''
        ]);

        return $payload;
    }

    public static function getQRCode()
    {

        return self::get();
    }

    public static function getQRCodeById($id)
    {
        return self::findOrFail($id);
    }

    public static function updateQRCode($id, $data)
    {
        $payload = self::findOrFail($id);
        
        $payload->update([
            'created_by_user_id' => $data['created_by_users_id'] ?? 0,
            'qrcode_number' => $data['qrcode_number'] ?? '',
            'amount' => $data['amount'] ?? '',
            'qrcode_generated' => $data['qrcode_generated'] ?? ''
        ]);

        return $payload;
    }

    public static function deleteQRCode($id)
    {
        return self::findOrFail($id)->delete();
    }
}
