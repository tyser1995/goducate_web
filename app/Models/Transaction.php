<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

use Vinkla\Hashids\Facades\Hashids;
use App\Models\CustomerModel;

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
        $customer = CustomerModel::getCustomerByEmail($data['email']);
        $payload = self::create([
            'created_by_user_id' => Auth::user()->id ?? 0,
            'customer_id' => $customer->id ?? '',
            'description' => $data['description'] == "others" ? $data['others'] :  $data['description'],
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

    public static function deleteTransactionAfterPrint($id)
    {
        return self::where('customer_id','=',$id)
        ->delete();
    }
}