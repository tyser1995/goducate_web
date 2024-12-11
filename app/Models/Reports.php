<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

use App\Models\BookingModel;

use DB;

class Reports extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reports';

    protected $fillable =[
        'created_by_user_id',
        'customer_id',
        'description',
        'type'
    ];

    public static function createReports($data)
    {
        $payload = self::create([
            'created_by_user_id' => Auth::user()->id ?? 0,
            'customer_id' => $data['customer_id'] ?? 0,
            'description' => $data['description'] ?? '',
            'type' => $data['title'] ?? ''
        ]);

        return $payload;
    }

    public static function getReports()
    {
        return self::select(
            'description',
            'type',
            DB::raw('COUNT(*) as count'))
        ->groupBy('description','type')
        ->get();
    }

    public static function getReportsById($id)
    {
        return self::findOrFail($id);
    }

    public static function updateReports($id, $data)
    {
        $payload = self::findOrFail($id);
        
        $payload->update([
            'created_by_user_id' => Auth::user()->id,
            'customer_id' => $data['customer_id'] ?? 0,
            'description' => $data['description'] ?? '',
            'type' => $data['type'] ?? ''
        ]);

        return $payload;
    }

    public static function deleteReports($id)
    {
        return self::findOrFail($id)->delete();
    }


    public static function getReportsChartActivity()
    {
        return self::select(
            DB::raw('MONTH(created_at) as month'),
            'description',
            DB::raw('COUNT(*) as count')
        )
        ->groupBy('month', 'description')
        ->get();
    }

    public static function getReportsChartBooking()
    {
        return BookingModel::select(
            DB::raw('MONTH(checkin_date) as month'),
            'accomodation_name',
            DB::raw('COUNT(*) as count')
        )
        ->groupBy(DB::raw('MONTH(checkin_date)'), 'accomodation_name')
        ->orderBy(DB::raw('MONTH(checkin_date)'), 'asc')
        ->get();
    }

}
