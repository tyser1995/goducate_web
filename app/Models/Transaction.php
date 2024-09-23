<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transactions';

    protected $fillable =[
        'created_by_user_id',
        'customer_id',
        'description',
        'amount',
    ];

    public const DESCRIPTION = [
        'recreational_activity'     => 'Recreational Activity',
        'food'                      => 'Food',
        'accomodation'              => 'Accomodation',
        'others'                    => 'Others'
    ];

    public static function createTransaction($data)
    {
        $payload = self::create([
            'created_by_user_id' => Auth::user()->id,
            'customer_id' => $data['customer_id'] ?? '',
            'description' => $data['description'] ?? '',
            'amount' => $data['amount'] ?? ''
        ]);

        return $payload;
    }

    public static function getTransaction($customer_id)
    {

        return self::selectRaw('
            transactions.id,
            transactions.description,
            transactions.amount
        ')
        ->join('customers', 'customers.id', '=', 'transactions.customer_id') 
        ->where('transactions.customer_id','=',$customer_id) 
        ->get();
    }

    public static function getTransactionById($id)
    {
        return self::findOrFail($id);
    }

    public static function updateTransaction($id, $data)
    {
        $payload = self::findOrFail($id);
        
        $payload->update([
            'created_by_user_id' => Auth::user()->id,
            'customer_id' => $data['customer_id'] ?? '',
            'description' => $data['description'] ?? '',
            'amount' => $data['amount'] ?? ''
        ]);

        return $payload;
    }

    public static function deleteTransaction($id)
    {
        return self::findOrFail($id)->delete();
    }
}