<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityHeader extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'activity_headers';

    protected $fillable =[
        'created_by_user_id',
        'description'
    ];

    public static function createActivityHeader($data)
    {
        $payload = self::create([
            'created_by_user_id' => $data['created_by_users_id'],
            'description' => htmlentities($data['summernote'])
        ]);

        return $payload;
    }

    public static function getActivityHeader()
    {
        return self::get();
    }

    // Function to get an item by ID with price
    public static function getActivityHeaderById($id)
    {
        return self::findOrFail($id);
    }

    public static function updateActivityHeader($id, $data)
    {
        // Find the AboutUs instance by ID
        $aboutUs = self::findOrFail($id);

        // Update the instance with the provided data
        $aboutUs->update([
            'created_by_user_id' => $data['created_by_users_id'],
            'description' => htmlentities($data['summernote']),
        ]);

        return $aboutUs;
    }

    public static function deleteActivityHeader($id)
    {
        return self::findOrFail($id)->delete();
    }
}
