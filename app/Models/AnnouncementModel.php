<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class AnnouncementModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "announcements";

    protected $fillable =[
        'created_by_user_id',
        'who',
        'what',
        'where',
        'when',
        'description',
        'attachment'
    ];

    public static function createAnnouncement($data)
    {
        $payload = self::create([
            'created_by_user_id' => $data['created_by_users_id'] ?? 0,
            'who' => $data['who'],
            'what' => $data['what'],
            'where' => $data['where'],
            'when' => $data['when'],
            'description' => htmlentities($data['description']),
            'attachment' => $data['attachment'] ?? null
        ]);

        return $payload;
    }

    public static function getAnnouncementList()
    {
        $announcements = self::all();

        foreach ($announcements as $announcement) {
            $dateRange = $announcement->when;

            $dates = explode(' - ', $dateRange);
            
            $endDateStr = $dates[1];

            $endDate = Carbon::createFromFormat('m/d/Y h:i A', $endDateStr);
            $now = Carbon::now();

            // If the current time is after or equal to the end date, delete the announcement
            if ($endDate->lessThanOrEqualTo($now)) {
                $announcement->delete();
            }
        }

        return self::selectRaw("
                Announcements.id,
                Announcements.name,
                Announcements.email,
                Announcements.address,
                Announcements.contact_no,
                CASE 
                    WHEN Announcements.boooking_status = 0 THEN Announcement_overnight_stays.checkin_date 
                    WHEN Announcements.boooking_status = 1 THEN Announcement_day_tours.checkin_date 
                    ELSE Announcement_place_reservations.checkin_date 
                END as checkin_date,
                CASE 
                    WHEN Announcements.boooking_status = 0 THEN Announcement_overnight_stays.checkout_date 
                    WHEN Announcements.boooking_status = 1 THEN Announcement_day_tours.checkout_date 
                    ELSE Announcement_place_reservations.checkout_date 
                END as checkout_date,
                Announcements.created_at
            ")
            ->leftJoin('Announcement_overnight_stays', function($join) {
                $join->on('Announcement_overnight_stays.email', '=', 'Announcements.email')
                    ->where('Announcements.boooking_status', '=', 0);
            })
            ->leftJoin('Announcement_day_tours', function($join) {
                $join->on('Announcement_day_tours.email', '=', 'Announcements.email')
                    ->where('Announcements.boooking_status', '=', 1); 
            })
            ->leftJoin('Announcement_place_reservations', function($join) {
                $join->on('Announcement_place_reservations.email', '=', 'Announcements.email')
                    ->where('Announcements.boooking_status', '!=', 2);
            })
            ->distinct()
            ->orderBy('Announcements.created_at','DESC')
            ->get();
    }

    public static function getAnnouncement()
    {
        $announcements = self::all();

        foreach ($announcements as $announcement) {
            $dateRange = $announcement->when;

            $dates = explode(' - ', $dateRange);
            
            $endDateStr = $dates[1];

            $endDate = Carbon::createFromFormat('m/d/Y h:i A', $endDateStr);
            $now = Carbon::now();

            // If the current time is after or equal to the end date, delete the announcement
            if ($endDate->lessThanOrEqualTo($now)) {
                $announcement->delete();
            }
        }

        return self::orderBy('created_at','DESC')->get();
    }

    public static function getAnnouncementById($id)
    {
        return self::findOrFail($id);
    }

    public static function updateAnnouncement($id, $data)
    {
        $payload = self::findOrFail($id);
        
        $payload->update([
            'created_by_user_id' => $data['created_by_users_id'] ?? 0,
            'who' => $data['who'],
            'what' => $data['what'],
            'where' => $data['where'],
            'when' => $data['when'],
            'description' => htmlentities($data['description']),
            'attachment' => $data['attachment'] ?? null
        ]);

        return $payload;
    }

    public static function deleteAnnouncement($id)
    {
        return self::findOrFail($id)->delete();
    }
}
