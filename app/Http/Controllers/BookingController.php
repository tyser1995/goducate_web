<?php

namespace App\Http\Controllers;

use App\Models\BookingModel;
use App\Models\BookingOvernightStayModel;
use App\Models\BookingDayTourModel;
use App\Models\BookingPlaceReservationModel;
use Illuminate\Http\Request;

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
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function edit(BookingModel $bookingModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BookingModel  $bookingModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BookingModel $bookingModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookingModel  $bookingModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookingModel $bookingModel)
    {
        //
    }

    public function booking_list(){
        $bookings = BookingModel::getBooking();

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
