<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'customers';

    protected $fillable =[
        'created_by_user_id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'address',
        'contact_no'
    ];

    public static function createCustomer($data)
    {
        $payload = self::create([
            'created_by_user_id' => $data['created_by_users_id'] ?? 0,
            'first_name' => $data['first_name'] ?? '',
            'middle_name' => $data['middle_name'] ?? '',
            'last_name' => $data['last_name'] ?? '',
            'email' => $data['email'],
            'address' => $data['address'] ?? '',
            'contact_no' => $data['contact_no'] ?? 0
        ]);

        return $payload;
    }

    public static function getCustomer()
    {
        // return self::selectRaw('
        //     customers.id,
        //     customers.created_by_user_id,
        //     customers.first_name,
        //     customers.middle_name,
        //     customers.last_name,
        //     customers.email,
        //     customers.address,
        //     customers.contact_no,
        //     users.id as users_id,
        //     users.name,
        //     users.email as users_email,
        //     users.created_at
        // ')
        // ->join('users', 'users.email', '=', 'customers.email') 
        // ->where('users.role', 4) 
        // ->orderBy('users.created_at', 'DESC')
        // ->get();
        return self::orderBy('created_at', 'DESC')
        ->get();
    }

    public static function getCustomerById($id)
    {
        return self::findOrFail($id);
    }

    public static function updateCustomer($id, $data)
    {
        $payload = self::findOrFail($id);
        
        $payload->update([
            'created_by_user_id' => $data['created_by_users_id'] ?? 0,
            'first_name' => $data['first_name'] ?? '',
            'middle_name' => $data['middle_name'] ?? '',
            'last_name' => $data['last_name'] ?? '',
            'address' => $data['address'] ?? '',
            'contact_no' => $data['contact_no'] ?? 0
        ]);

        return $payload;
    }

    public static function deleteCustomer($id)
    {
        return self::findOrFail($id)->delete();
    }

    public static function getCustomerByEmail($email)
    {
        return self::where('email','=',$email)->first();
    }
}
