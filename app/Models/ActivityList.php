<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityList extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'activity_lists';

    protected $fillable =[
        'created_by_user_id',
        'title',
        'description',
        'image'
    ];

    public static function createActivityList($data)
    {
        $payload = self::create([
            'created_by_user_id' => $data['created_by_users_id'],
            'description' => htmlentities($data['summernote']),
            'title' => $data['title'],
            'image' => $data['image']
        ]);

        return $payload;
    }

    public static function getActivityList()
    {
        return self::get();
    }

    public static function getActivityListByPageId($id)
    {
        return self::where('id',$id)->get();
    }

    public static function getActivityListById($id)
    {
        return self::findOrFail($id);
    }

    public static function updateActivityList($id, $data)
    {
        // Find the AboutUs instance by ID
        $aboutUs = self::findOrFail($id);

        // Update the instance with the provided data
        $aboutUs->update([
            'created_by_user_id' => $data['created_by_users_id'],
            'description' => htmlentities($data['summernote']),
            'title' => $data['title'],
            'image' => $data['image']
        ]);

        return $aboutUs;
    }

    public static function deleteActivityList($id)
    {
        return self::findOrFail($id)->delete();
    }
}
