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
        'religion',
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
        "15 or younger" => "15 or younger",
        "16–19" => "16–19",
        "20–24" => "20–24",
        "25–29" => "25–29",
        "30–34" => "30–34",
        "35–39" => "35–39",
        "40–44" => "40–44",
        "45–49" => "45–49",
        "50–54" => "50–54",
        "55–59" => "55–59",
        "60–64" => "60–64",
        "65 or up" => "65 or older"
    ];

    public const SERVICE_TYPE = [
        'food_resto'        => 'Food/Resto',
        'accomodations'     => 'Accomodations',
        'recreations_act'   => 'Recreations Activities',
        'place'             => 'Place',
        'services'          => 'Services',
    ];

    public const RELIGION = [
        "Protestantism" => "Protestantism",
        "Catholicism" => "Catholicism",
        "Christianity" => "Christianity",
        "Judaism" => "Judaism",
        "Islam" => "Islam",
        "Buddhism" => "Buddhism",
        "Hinduism" => "Hinduism",
        "Inter/Non-denominational" => "Inter/Non-denominational",
        "No_Religion" => "No religion",
        "Other" => "Other (please specify)",
        "Prefer_not_to_disclose" => "Prefer not to disclose"
    ];

    public static function createSurvey($data)
    {
        $payload = self::create([
            'group_type' => $data['group_type'],
            'person_type' => $data['person_type'] ?? 'na',
            'address' => $data['address'] ?? 'na',
            'religion' => $data['religion'] == "Other" ? $data['other_religion'] : $data['religion'],
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
            'religion' => $data['religion'] == "Other" ? $data['other_religion'] : $data['religion'],
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
        $ratings = json_encode([
            'food_resto'      => $data['food_resto'],
            'accomodations'   => $data['accommodation'],
            'recreations_act' => $data['recreation'],
            'place'           => $data['place'],
            'services'        => $data['services'],
        ]);

        $ratingsArray = json_decode($ratings, true);
        foreach (self::SERVICE_TYPE as $key => $value) {
            if (array_key_exists($key, $ratingsArray)) {

                $ratingValue = $ratingsArray[$key];
                $payload = self::create([
                    'ratings' => $ratingValue,
                    'type'    => 'feedback',
                    'services' => $key,
                ]);
            }
        }

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
