<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AboutUs extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'about_us';

    protected $fillable =['created_by_user_id','description'];

    public static function createAboutUsPage($data)
    {
        $payload = self::create([
            'created_by_user_id' => $data['created_by_users_id'],
            'description' => htmlentities($data['summernote'])
        ]);

        return $payload;
    }

    // Function to get list of items with prices
    public static function getAboutUsPage()
    {
        return self::get();
    }

    // Function to get an item by ID with price
    public static function getAboutUsPageById($id)
    {
        return self::findOrFail($id);
    }

    public static function updateAboutUsPage($id, $data)
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

    public static function deleteAboutUsPage($id)
    {
        return self::findOrFail($id)->delete();
    }
}
