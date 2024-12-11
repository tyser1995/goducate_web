<?php

namespace App\Http\Controllers;

use App\Models\BookingModel;
use App\Models\BookingOvernightStayModel;
use App\Models\BookingDayTourModel;
use App\Models\BookingPlaceReservationModel;
use App\Models\CustomerModel;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('pages.booking.index',[
            'bookings' => BookingModel::getBookingv2(),
            'customers' => CustomerModel::getCustomer()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('pages.booking.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BookingModel  $bookingModel
     * @return \Illuminate\Http\Response
     */
    public function show(BookingModel $bookingModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BookingModel  $bookingModel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $customers = CustomerModel::findOrFail(Hashids::decode($id)[0]);
        $booking = BookingModel::getBookingByEmail($customers->email)->first();
        return view('pages.booking.edit',[
            'bookings' => BookingModel::getBookingById($booking->id),
            'overnight_stays' => BookingOvernightStayModel::getOvernightStayByEmail($booking->email),
            'day_tours' => BookingDayTourModel::getDayTourByEmail($booking->email),
            'place_reservations' => BookingPlaceReservationModel::getPlaceReservationByEmail($booking->email)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BookingModel  $bookingModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $customers = CustomerModel::findOrFail($id);
        $bookings = BookingModel::getBookingByEmail($customers->email);
        foreach ($bookings as $booking) {
            BookingModel::getBookingById($booking->id);
            BookingModel::updateBookingStatus($booking->id,$request->all());

            BookingOvernightStayModel::updateOvernightStayStatus($booking->email,$request->all());
            BookingDayTourModel::updateDayTourStatus($booking->email,$request->all());
            BookingPlaceReservationModel::updatePlaceReservationStatus($booking->email,$request->all());
        }

        return redirect()->route('booking.index')->withStatus(__('Updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookingModel  $bookingModel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $customers = CustomerModel::findOrFail($id);
        $bookings = BookingModel::getBookingByEmail($customers->email);
        foreach ($bookings as $booking) {
            BookingModel::deleteBooking($booking->id);
        }
        
        return redirect()->route('booking.index')->withError(__('Deleted successfully'));
    }

    public function booking_list(){
        $bookings = BookingModel::getBooking();
        $booking_list = BookingModel::getBookingListv2();
        return response()->json([
            'success' => true,
            'data' => $bookings,
            'booking_list' =>$booking_list,
            'datav3' => BookingModel::getBookingListv3()
        ], 200);
    }

    public function booking_list_dashboard(){
        $bookings = BookingModel::getBookingListTable();

        return response()->json([
            'success' => true,
            'data' => $bookings
        ], 200);
    }

    public function booking_store(Request $request){
        BookingModel::createBooking($request->all());
    }

    //Overnight Stay
    public function os_store(Request $request){
        BookingOvernightStayModel::createOvernightStay($request->all());
    }

    //Day Tour
    public function dt_store(Request $request){
        BookingDayTourModel::createDayTour($request->all());
    }

    //Place Reservation
    //Day Tour
    public function pr_store(Request $request){
        BookingPlaceReservationModel::createPlaceReservation($request->all());
    }
}
