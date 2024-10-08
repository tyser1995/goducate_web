<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'payments';

    protected $fillable =[
        'created_by_user_id',
        'customer_id',
        'amount',
        'attachment'
    ];

    public static function createPayment($data)
    {
        return self::create([
            'created_by_user_id' => Auth::user()->id ?? 0,
            'customer_id' => $data['customer_id'] ?? 0,
            'amount' => $data['amount'] ?? 0,
            'attachment' => $data['attachment'] ?? ''
        ]);
    }

    public static function getPaymentByCustomerId($customer_id)
    {

        return self::where('customer_id','=',$customer_id)
        ->get();
    }

    public static function getPaymentById($id)
    {
        return self::findOrFail($id);
    }

    public static function updatePayment($id, $data)
    {
        $payload = self::findOrFail($id);
        
        $payload->update([
            'created_by_user_id' => Auth::user()->id ?? 0,
            'customer_id' => $data['customer_id'] ?? 0,
            'amount' => $data['amount'] ?? 0,
            'attachment' => $data['attachment'] ?? ''
        ]);

        return $payload;
    }

    public static function deletePayment($id)
    {
        return self::findOrFail($id)->delete();
    }
}
