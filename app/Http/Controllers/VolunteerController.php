<?php

namespace App\Http\Controllers;

use App\Models\VolunteerModel;
use Illuminate\Http\Request;

class VolunteerController extends Controller
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
     * @param  \App\Models\VolunteerModel  $volunteerModel
     * @return \Illuminate\Http\Response
     */
    public function show(VolunteerModel $volunteerModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VolunteerModel  $volunteerModel
     * @return \Illuminate\Http\Response
     */
    public function edit(VolunteerModel $volunteerModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VolunteerModel  $volunteerModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VolunteerModel $volunteerModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VolunteerModel  $volunteerModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(VolunteerModel $volunteerModel)
    {
        //
    }

    public function volunteer_page(Request $request){
        return view('pages.volunteer_page');
    }

    public function register(Request $request){
        //
        VolunteerModel::createVolunteer($request->all());
        return redirect()->route('_volunteer')->withStatus(__('Successfully created.'));
    }
}
