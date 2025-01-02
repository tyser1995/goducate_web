<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class BookingDayTourModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'booking_day_tours';

    protected $fillable =[
        'created_by_user_id',
        'customer_id',
        'name',
        'email',
        'tour_type',
        'group_type',
        'room_type',
        'no_of_persons',
        'checkin_date',
        'checkout_date',
        'status'
    ];

    public const TOUR_TYPE = [
        'team_building'    => 'Team Building',
        'family'    => 'Family Fun and Learning',
        'place_reservation'    => 'Place Reservation'
    ];

    public const GROUP_TYPE = [
        'church'    => 'Church',
        'school'    => 'School',
        'corporate' => 'Corporate',
        'others'    => 'Others'
    ];

    public static function createDayTour($data)
    {
        $roomTypes = is_array($data['tour_type']) ? $data['tour_type'] : [$data['tour_type']];
        $payload = [];
        $partial_amount = 0;

        foreach ($roomTypes as $roomTypeId) {
            $roomType = Accomodation::find($roomTypeId); // Adjust according to your model method
            $roomTypeName = $roomType ? $roomType->type : null; // Replace 'name' with the actual column name

            if ($roomType && is_numeric($roomType->amount)) {
                $partial_amount += $roomType->amount;
            }

            // $payload[] = self::create([
            //     'created_by_user_id' => $data['created_by_users_id'] ?? 0,
            //     'customer_id'        => $data['customer_id'] ?? 0,
            //     'email'              => $data['email'],
            //     'room_type'          => $roomTypeName,
            //     'checkin_date'       => $data['checkin_date'],
            //     'checkout_date'      => $data['checkout_date'],
            //     'status'             => 'pending'
            // ]);
            $payload = self::create([
                'created_by_user_id' => $data['created_by_users_id'] ?? 0,
                'customer_id' => $data['customer_id'] ?? 0,
                'name' => $data['name'] ?? '',
                'email' => $data['email'],
                'tour_type' => $data['tour_type'],
                'group_type' => $data['group_type'] ?? 0,
                'room_type' => $roomTypeName,
                'no_of_persons' => $data['no_of_persons'] ?? 0,
                'checkin_date' => $data['checkin_date'],
                'checkout_date' => $data['checkout_date'],
                'status' => 'pending'
            ]);
        }

        
        
        $customer = CustomerModel::getCustomerByEmail($data['email']);
        $customer_id = 0;

        if(!$customer){
            $new_customer = CustomerModel::create([
                'created_by_user_id' => $data['created_by_users_id'] ?? 0,
                'first_name' => $data['first_name'] ?? '',
                'middle_name' => $data['middle_name'] ?? '',
                'last_name' => $data['last_name'] ?? '',
                'email' => $data['email'],
                'address' => $data['address'] ?? '',
                'contact_no' => $data['contact_no'] ?? 0
            ]);

            $customer_id = $new_customer->id;
        } else {
            $customer_id = $customer->id;
        }
        
        $total_amount = $partial_amount;
        $partial_amount *= 0.20;
        $emailDetails = [
            'title' => 'Reservation Confirmation',
            'body' => 'Reservation will be confirmed upon 20% of down payment made through the following payment channels.',
            'reservation' => $payload,
            'booking_status' => 'day_tour',
            'customer_id' => $customer_id,
            'partial_amount' => $partial_amount,
            'total_amount' => $total_amount
        ];

    
        $notification = [
            'created_by_user_id' => $data['created_by_users_id'] ?? 0,
            'customer_id' => $customer_id,
            'type' => 'booking',
            'status' => 'pending',
        ];
        
        \App\Models\Notification::createNotification($notification);

        Mail::to($data['email'])->send(new \App\Mail\SendMail($emailDetails));
        return $payload;
    }

    public static function getDayTour()
    {
        return self::get();
    }

    public static function getDayTourById($id)
    {
        return self::findOrFail($id);
    }

    public static function getDayTourByEmail($email,$IsBook=true)
    {
        if($IsBook){
            return self::where('email','=',$email)
            ->where('status','=','pending')
            ->get();
        }else{
            return self::where('email','=',$email)
            ->get();
        }
        
    }

    public static function updateDayTour($id, $data)
    {
        $payload = self::findOrFail($id);
        
        $payload->update([
            'created_by_user_id' => $data['created_by_users_id'] ?? 0,
            'customer_id' => $data['customer_id'] ?? 0,
            'name' => $data['name'] ?? '',
            'email' => $data['email'],
            'tour_type' => $data['tour_type'],
            'group_type' => $data['group_type'] ?? 0,
            'room_type' => $data['room_type'] ?? 0,
            'no_of_persons' => $data['no_of_persons'] ?? 0,
            'checkin_date' => $data['checkin_date'],
            'checkout_date' => $data['checkout_date']
        ]);

        return $payload;
    }

    public static function updateDayTourStatus($email, $data)
    {
        $payload = self::where('email', '=', $email)
        ->where('status','pending')
        ->get();
    
        if ($payload->isNotEmpty()) {
            foreach ($payload as $record) {
                $record->update([
                    'status' => $data['status']
                ]);
            }
        }

        return $payload;
    }

    public static function deleteDayTour($id)
    {
        return self::findOrFail($id)->delete();
    }
}
