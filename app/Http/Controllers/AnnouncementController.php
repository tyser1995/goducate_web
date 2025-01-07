<?php

namespace App\Http\Controllers;

use App\Models\AnnouncementModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Vinkla\Hashids\Facades\Hashids;

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

        return view('pages.announcement.index',[
            'announcements' => AnnouncementModel::getAnnouncement()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.announcement.create');
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
        if ($request->hasFile('attachment')) {
            $image = $request->file('attachment');
            $image_name = $image->getClientOriginalName();
            
            $destination_path = public_path('/images/announcement/');
    
            // Check if the directory exists, if not, create it
            if (!File::exists($destination_path)) {
                File::makeDirectory($destination_path, 0755, true);
            }
    
            // Move the uploaded file to the destination path
            $image->move($destination_path, $image_name);
    
            // Add the image name to the request data
            $input = $request->all();
            $input['attachment'] = $image_name;

           
        }else{
            $input = $request->all();
            $input['attachment'] = 'default-announcement.png';
        }
    
        AnnouncementModel::createAnnouncement($input);
    
        return redirect()->route('announcement.index')->withStatus(__('Successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AnnouncementModel  $announcementModel
     * @return \Illuminate\Http\Response
     */
    public function show(AnnouncementModel $announcementModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AnnouncementModel  $announcementModel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        return view('pages.announcement.edit',[
            'announcements' =>  AnnouncementModel::getAnnouncementById(Hashids::decode($id)[0])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AnnouncementModel  $announcementModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $announcement = AnnouncementModel::find($id);

        if ($request->hasFile('attachment')) {
            $image = $request->file('attachment');
            
            $image_name = $image->getClientOriginalName();
            
            $destination_path = public_path('/images/announcement/');
    
            if (!File::exists($destination_path)) {
                File::makeDirectory($destination_path, 0755, true);
            }
    
            $image->move($destination_path, $image_name);
            $input['attachment'] = $image_name;

            if ($announcement->attachment && File::exists($destination_path . $announcement->attachment)) {
                File::delete($destination_path . $announcement->attachment);
            }
        }else {
            $input['attachment'] = $announcement->attachment;
        }
    
        $announcement->update($input);
    
        return redirect()->route('announcement.index')->withStatus(__('Successfully updated.'));
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AnnouncementModel  $announcementModel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        AnnouncementModel::deleteAnnouncement($id);
        return redirect()->route('announcement.index')->withStatus(__('Successfully deleted.'));
    }
}
