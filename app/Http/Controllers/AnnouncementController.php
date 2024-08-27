<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Announcement;

use Carbon\Carbon;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $announcement = Announcement::orderBy('created_at','DESC')
        ->get();
        return view('announcement.index',[
            'announcement' => $announcement
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
        return view('announcement.create');
    }

    public function save_update($request = []){
        $announcement = Announcement::find($request->id);
        if(empty($announcement)){
            $announcement = new Announcement;
        }

        $announcement->created_by_user_id = Auth::user()->id;
        $announcement->who = $request->who;
        $announcement->what = $request->what;
        $announcement->where = $request->where;
        $announcement->when = new Carbon($request->when);
        $announcement->attachment = $request->attachment;
        $announcement->save();
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
        $this->save_update($request);
        return redirect()->route('announcements')->withStatus(__('Announcement successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Announcement $announcement )
    {
        //
        return view('announcement.edit',[
            'announcement' => $announcement
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $this->save_update($request);
        return redirect()->route('announcements')->withStatus(__('Announcement successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
