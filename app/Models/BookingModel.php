<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use App\Models\CustomerModel;
use App\Models\Accomodation;

use DB;

class BookingModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bookings';

    protected $fillable =[
        'created_by_user_id',
        'customer_id',
        'name',
        'email',
        'address',
        'contact_no',
        'no_of_adults',
        'no_of_children',
        'boooking_status',
        'accomodation_id',
        'accomodation_name',
        'accomodation_availability',
        'accomodation_qty',
        'accomodation_taken',
        'checkin_date',
        'checkout_date',
        'status'
    ];

    // protected $attributes = [
    //     'created_by_user_id' => 0, 
    //     'customer_id' => 0,
    //     'name' => 'Guest',
    //     'email' => 'no-reply@example.com',
    //     'address' => '',
    //     'contact_no' => '',
    //     'no_of_adults' => 1,
    //     'no_of_children' => 0,
    //     'booking_status' => '',
    // ];

    public static function createBooking($data)
    {
        $roomTypes = is_array($data['accomodation_id']) ? $data['accomodation_id'] : [$data['accomodation_id']];
        $payload = [];
        foreach ($roomTypes as $roomTypeId){

            $roomType = Accomodation::find($roomTypeId);
            $roomTypeName = $roomType ? $roomType->type : null;

            $payload[] = self::create([
                'created_by_user_id' => $data['created_by_users_id'] ?? 0,
                'customer_id'       => $data['customer_id'] ?? 0,
                'name'              => $data['name'],
                'email'             => $data['email'],
                'address'           => $data['address'],
                'contact_no'        => $data['contact_no'],
                'no_of_adults'      => $data['no_of_adults'],
                'no_of_children'    => $data['no_of_children'],
                'boooking_status'   => $data['boooking_status'],
                'checkin_date'      => $data['checkin_date'],
                'checkout_date'     => $data['checkout_date'],
                'accomodation_id'   => $roomTypeId,
                'accomodation_name' => $roomTypeName,
                'accomodation_qty'  => $roomType->qty,
                'accomodation_taken' => 1,
                'status'            => 'pending'
            ]);
        }

        return $payload;
    }

    public static function getBookingList()
    {
        return self::selectRaw("
                bookings.id,
                bookings.name,
                bookings.email,
                bookings.address,
                bookings.contact_no,
                bookings.status,
                CASE
                    WHEN bookings.boooking_status = 0 THEN booking_overnight_stays.checkin_date 
                    WHEN bookings.boooking_status = 1 THEN booking_day_tours.checkin_date 
                    ELSE booking_place_reservations.checkin_date 
                END as checkin_date,
                CASE
                    WHEN bookings.boooking_status = 0 THEN booking_overnight_stays.checkout_date 
                    WHEN bookings.boooking_status = 1 THEN booking_day_tours.checkout_date 
                    ELSE booking_place_reservations.checkout_date 
                END as checkout_date,
                bookings.created_at
            ")
            ->leftJoin('booking_overnight_stays', function($join) {
                $join->on('booking_overnight_stays.email', '=', 'bookings.email')
                    ->where('bookings.boooking_status', '=', 0);
            })
            ->leftJoin('booking_day_tours', function($join) {
                $join->on('booking_day_tours.email', '=', 'bookings.email')
                    ->where('bookings.boooking_status', '=', 1); 
            })
            ->leftJoin('booking_place_reservations', function($join) {
                $join->on('booking_place_reservations.email', '=', 'bookings.email')
                    ->where('bookings.boooking_status', '!=', 2);
            })
            ->distinct()
            ->orderBy('bookings.created_at','DESC')
            ->get();
    }

    public static function getBookingListv2()
    {
        return self::selectRaw("
                accomodations.type,
                CONCAT(
                    DATE(bookings.checkin_date), ' ',TIME(bookings.created_at)
                ) as
                combined_checkin_datetime,
                CONCAT(
                    DATE(bookings.checkout_date), ' ',TIME(bookings.created_at)
                ) as combined_checkout_datetime,
                accomodations.qty,
                accomodations.capacity
            ")
            ->leftJoin('accomodations', function($join) {
                $join->on('accomodations.bookig_status', '=', 'bookings.boooking_status');
            })
            // ->groupBy(
            //     'type',
            //     'combined_checkin_datetime',
            //     'combined_checkout_datetime',
            //     'accomodations.qty',
            //     'accomodations.capacity'
            // )
            ->distinct()
            // ->orderBy('bookings.created_at','DESC')
            ->get();
    }

    public static function getBookingListv3()
    {
        return self::select('accomodation_name', 'checkin_date', 'checkout_date', 'accomodation_qty',
            DB::raw('SUM(accomodation_taken) as accomodation_taken'))
        ->groupBy('accomodation_name', 'checkin_date', 'checkout_date')
        ->orderBy('bookings.created_at', 'DESC')
        ->get();
    }

    public static function getBookingListTable()
    {
        return self::selectRaw("
                bookings.id,
                bookings.name,
                bookings.email,
                bookings.address,
                bookings.status,
                bookings.contact_no,
                CONCAT(
                    DATE(bookings.checkin_date), ' ',TIME(bookings.created_at)
                ) as
                combined_checkin_datetime,
                CONCAT(
                    DATE(bookings.checkout_date), ' ',TIME(bookings.created_at)
                ) as combined_checkout_datetime
            ")
            ->where('status','=','pending')
            // ->leftJoin('booking_overnight_stays', function($join) {
            //     $join->on('booking_overnight_stays.email', '=', 'bookings.email')
            //         ->where('bookings.boooking_status', '=', 0);
            // })
            // ->leftJoin('booking_day_tours', function($join) {
            //     $join->on('booking_day_tours.email', '=', 'bookings.email')
            //         ->where('bookings.boooking_status', '=', 1); 
            // })
            // ->leftJoin('booking_place_reservations', function($join) {
            //     $join->on('booking_place_reservations.email', '=', 'bookings.email')
            //         ->where('bookings.boooking_status', '=', 2);
            // })
            ->distinct()
            ->orderBy('combined_checkin_datetime','DESC')
            ->get();
    }

    public static function getBooking()
    {
        return self::get();
    }

    public static function getBookingById($id)
    {
        return self::findOrFail($id);
    }

    public static function getBookingByEmail($email)
    {
        return self::where('email','=',$email)
        ->orderBy('created_at','DESC')
        ->get();
    }

    public static function updateBooking($id, $data)
    {
        $payload = self::findOrFail($id);
        
        $payload->update([
            'created_by_user_id' => $data['created_by_users_id'] ?? 0,
            'customer_id' => $data['customer_id'] ?? 0,
            'name' => $data['name'],
            'email' => $data['email'],
            'address' => $data['address'],
            'contact_no' => $data['contact_no'],
            'no_of_adults' => $data['no_of_adults'],
            'no_of_children' => $data['no_of_children'],
            'boooking_status' => $data['boooking_status']
        ]);

        $customer = CustomerModel::getCustomerByEmail($data['email']);
        $customer_id = 0;

        if(!$customer){
            $new_customer = CustomerModel::create([
                'created_by_user_id' => Auth::user()->id ?? 0,
                'first_name' => $payload->name ?? '',
                'middle_name' => '',
                'last_name' => '',
                'email' => $payload->email,
                'address' => $data['address'],
                'contact_no' => $data['contact_no'] ?? 0
            ]);

            $customer_id = $new_customer->id;
        } else {
            $customer_id = $customer->id;
        }


        $emailDetails = [
            'title' => 'Reservation Confirmation',
            'body' => 'Reservation will be confirmed upon 20% of down payment made through the following payment channels.',
            'reservation' => $payload,
            'booking_status' => $data['boooking_status'],
            'customer_id' => $customer_id
        ];
    
        Mail::to($data['email'])->send(new \App\Mail\SendMail($emailDetails));

        return $payload;
    }

    public static function updateBookingStatus($id, $data)
    {
        $payload = self::findOrFail($id);
        
        $payload->update([
            'status' => $data['status']
        ]);
        
        $customer = CustomerModel::getCustomerByEmail($payload->email);
        if(!$customer){
            CustomerModel::create([
                'created_by_user_id' => Auth::user()->id ?? 0,
                'first_name' => $payload->name ?? '',
                'middle_name' => '',
                'last_name' =>  $payload->address ?? '',
                'email' => $payload->email,
                'address' => '',
                'contact_no' => $payload->contact_no ?? 0
            ]);
        }else{
            $customer->update([
                'created_by_user_id' => Auth::user()->id ?? 0,
                'first_name' => $payload->name ?? '',
                'middle_name' => '',
                'last_name' =>  $payload->address ?? '',
                'email' => $payload->email,
                'address' => '',
                'contact_no' => $payload->contact_no ?? 0
            ]);
        }

        $accomodation = Accomodation::getAccomodationById($payload->accomodation_id);

        $data_new = [
            'email' => $payload->email,
            'created_by_user_id' => Auth::user()->id ?? 0,
            'customer_id' => $customer->id ?? '',
            'description' => $accomodation->type ?? '',
            'amount' => $accomodation->amount ?? 0
        ];

        
        Transaction::createTransaction($data_new);

        $booking_status = 0;
        if($payload['boooking_status'] == 0){
            $booking_status = 'overnight_stay';
        }elseif($payload['boooking_status'] == 1){
            $booking_status = 'day_tour';
        }
        elseif($payload['boooking_status'] == 2){
            $booking_status = 'place_reservation';
        }else{
            //
        }
            
        $emailDetails = [
            'title' => 'Reservation Approved',
            'body' => 'Your reservation has been approved. Please visit the Goducate website and feel free to contact us if you have any other concerns. Thank you for choosing Goducate!',
            'reservation' => $payload,
            'booking_status' => $booking_status,
            'email' => $payload->email
        ];
    
        Mail::to($payload['email'])->send(new \App\Mail\SendApprovedMail($emailDetails));

        return $payload;
    }

    public static function deleteBooking($id)
    {
        return self::findOrFail($id)->delete();
    }
}
