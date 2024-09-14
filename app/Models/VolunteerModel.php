<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use DB;
class VolunteerModel extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'volunteers';

    protected $fillable =[
        'created_by_user_id',
        'name',
        'age',
        'email',
        'address',
        'birthday',
        'church_name',
        'pastor_name',
        'pastor_recommendation'
    ];

    public static function createVolunteer($data)
    {
        $payload = self::create([
            'created_by_user_id' => $data['created_by_users_id'] ?? 0,
            'name' => $data['name'],
            'age' => $data['age'] ?? 0,
            'email' => $data['email'],
            'address' => $data['address'],
            'birthday' => $data['birthday'],
            'church_name' => $data['church_name'],
            'pastor_name' => $data['pastor_name'],
            'pastor_recommendation' => $data['pastor_recommendation']
        ]);

        return $payload;
    }

    public static function getVolunteer()
    {
        return self::orderBy('created_at','DESC')
            ->get();
    }

    public static function getVolunteerById($id)
    {
        return self::findOrFail($id);
    }

    public static function updateVolunteer($id, $data)
    {
        $payload = self::findOrFail($id);
        
        $payload->update([
            'created_by_user_id' => $data['created_by_users_id'] ?? 0,
            'name' => $data['name'],
            'age' => $data['age'] ?? 0,
            'email' => $data['email'],
            'address' => $data['address'],
            'birthday' => $data['birthday'],
            'church_name' => $data['church_name'],
            'pastor_name' => $data['pastor_name'],
            'pastor_recommendation' => $data['pastor_recommendation']
        ]);

        return $payload;
    }

    public static function deleteVolunteer($id)
    {
        return self::findOrFail($id)->delete();
    }
}
