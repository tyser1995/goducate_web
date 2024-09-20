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
        return view('pages.volunteer.index',[
            'volunteers' => VolunteerModel::getVolunteer()
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
        return view('pages.volunteer.create');
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
        VolunteerModel::createVolunteer($request->all());
        return redirect()->route('volunteer.index')->withStatus(__('Successfully created.'));
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
    public function edit($id)
    {
        //
        return view('pages.volunteer.edit',[
            'volunteer' => VolunteerModel::getVolunteerById($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VolunteerModel  $volunteerModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        VolunteerModel::updateVolunteer($id, $request->all());
        return redirect()->route('volunteer.index')->withStatus(__('Successfully Updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VolunteerModel  $volunteerModel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        VolunteerModel::deleteVolunteer($id);
        return redirect()->route('volunteer.index')->withError(__('Deleted successfully'));
    }

    public function volunteer_page(Request $request){
        return view('pages.volunteer_page');
    }

    public function register(Request $request){
        //
        VolunteerModel::createVolunteer($request->all());
        return redirect()->route('_volunteer')->withStatus(__('Successfully created.'));
    }

    public function verify_volunteer($id){
        VolunteerModel::verifyVolunteer($id);
        return redirect()->route('volunteer.index')->withStatus(__('Successfully approved.'));
    }
}
