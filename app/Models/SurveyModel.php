<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurveyModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'surveys';

    protected $fillable =[
        'group_type',
        'person_type',
        'address',
        'ratings',
        'services',
        'type'
    ];

    public const GROUP_TYPE = [
        'family'        => 'Family',
        'organization'  => 'Organization',
        'company'       => 'Company',
        'others'        => 'Others'
    ];

    public const PERSON_TYPE = [
        'adults'  => '18 y.o and above',
        'kids'    => '17 and below'
    ];

    public const SERVICE_TYPE = [
        'food_resto'        => 'Food/Resto',
        'accomodations'     => 'Accomodations',
        'recreations_act'   => 'Recreations Activities',
        'place'             => 'Place',
        'services'          => 'Services',
    ];

    public static function createSurvey($data)
    {
        $payload = self::create([
            'group_type' => $data['group_type'],
            'person_type' => $data['person_type'] ?? 'na',
            'address' => $data['address'] ?? 'na',
            'type'    => 'survey'
        ]);

        return $payload;
    }

    public static function getSurvey()
    {
        return self::where('type','=','survey')
        ->get();
    }

    public static function getSurveyById($id)
    {
        return self::findOrFail($id);
    }

    public static function updateSurvey($id, $data)
    {
        $payload = self::findOrFail($id);
        
        $payload->update([
            'group_type' => $data['group_type'],
            'person_type' => $data['first_name'] ?? 'na',
            'address' => $data['address'] ?? 'na',
            'type'    => 'survey'
        ]);

        return $payload;
    }

    public static function deleteSurvey($id)
    {
        return self::findOrFail($id)->delete();
    }

    //Feedback
    public static function createFeedback($data)
    {
        $payload = self::create([
            'ratings' => $data['ratings'],
            'type'    => 'feedback',
            'services' => $data['services'],
        ]);

        return $payload;
    }

    public static function getFeedback()
    {
        return self::where('type','=','feedback')
        ->get();
    }

    public static function getFeedbackCount()
    {
        return self::selectRaw('services, ratings, count(*) as rating_count')
        ->where('type', '=', 'feedback')
        ->groupBy('services', 'ratings')
        ->get();
    }

    public static function getFeedbackById($id)
    {
        return self::findOrFail($id);
    }

    public static function updateFeedback($id, $data)
    {
        $payload = self::findOrFail($id);
        
        $payload->update([
            'ratings' => $data['ratings'],
            'type'    => 'feedback',
            'services' => $data['services'],
        ]);

        return $payload;
    }

    public static function deleteFeedback($id)
    {
        return self::findOrFail($id)->delete();
    }
}
