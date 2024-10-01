<?php

namespace App\Http\Controllers;

use App\Models\Accomodation;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class AccomodationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('accomodation.index',[
            'accomodations' => Accomodation::getAccomodation()
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
        return view('accomodation.create');
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
        Accomodation::createAccomodation($request->all());
        return redirect()->route('accomodation.create')->withStatus(__('Successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Accomodation  $accomodation
     * @return \Illuminate\Http\Response
     */
    public function show(Accomodation $accomodation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Accomodation  $accomodation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        return view('accomodation.edit',[
            'accomodations' =>  Accomodation::getAccomodationById(Hashids::decode($id)[0])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Accomodation  $accomodation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        Accomodation::updateAccomodation($id, $request);
        return redirect()->route('accomodation.index')->withStatus(__('Successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accomodation  $accomodation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Accomodation::deleteAccomodation($id);
        return redirect()->route('accomodation.index')->withError(__('Successfully deleted.'));
    }

    public function getRoomCapacity($id)
    {
        $room = Accomodation::find($id);
        
        if ($room) {
            return response()->json(['capacity' => $room->capacity]);
        } else {
            return response()->json(['error' => 'Room not found'], 404);
        }
    }
}
