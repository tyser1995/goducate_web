<?php

namespace App\Http\Controllers;

use App\Models\ActivityHeader;
use App\Models\ActivityList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Vinkla\Hashids\Facades\Hashids;

class ActivityPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.activity.index',[
            'headers' => ActivityHeader::getActivityHeader(),
            'lists' => ActivityList::getActivityList()
        ]);
    }

    public function activity_page()
    {
        return view('pages.activities',[
            'headers' => ActivityHeader::getActivityHeader(),
            'lists' => ActivityList::getActivityList()
        ]);
    }

    public function activity_page_id($id)
    {
        return view('pages.activities_pages',[
            'headers' => ActivityHeader::getActivityHeader(),
            'lists' => ActivityList::getActivityListByPageId(Hashids::decode($id))
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
        return view('pages.activity.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_list()
    {
        //
        return view('pages.activity.list.create');
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
        ActivityHeader::createActivityHeader($request->all());
        return redirect()->route('activity.index')->withStatus(__('Successfully created.'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_list(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            
            $destination_path = public_path('/images/header_list/');
    
            // Check if the directory exists, if not, create it
            if (!File::exists($destination_path)) {
                File::makeDirectory($destination_path, 0755, true);
            }
    
            // Move the uploaded file to the destination path
            $image->move($destination_path, $image_name);
    
            // Add the image name to the request data
            $input = $request->all();
            $input['image'] = $image_name;
    
            // Create the activity list entry
            ActivityList::createActivityList($input);
    
            return redirect()->route('activity.index')->withStatus(__('Successfully created.'));
        }
    
        return redirect()->route('activity.index')->withError(__('Error.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ActivityPage  $activityPage
     * @return \Illuminate\Http\Response
     */
    public function show(ActivityPage $activityPage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ActivityPage  $activityPage
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $headers = ActivityHeader::getActivityHeaderById($id);
        return view('pages.activity.edit',[
            'headers' => $headers
        ]);
    }

    public function edit_list($id)
    {
        //
        $lists = ActivityList::getActivityListById($id);
        return view('pages.activity.list.edit',[
            'lists' => $lists
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ActivityPage  $activityPage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        ActivityHeader::updateActivityHeader($id, $request->all());
        return redirect()->route('activity.index')->withStatus(__('Successfully Updated.'));
    }

    public function update_list(Request $request, $id)
    {
        //
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            
            $destination_path = public_path('/images/header_list/');
    
            // Check if the directory exists, if not, create it
            if (!File::exists($destination_path)) {
                File::makeDirectory($destination_path, 0755, true);
            }
            
            $image->move($destination_path, $image_name);
    
            // Add the image name to the request data
            $input = $request->all();
            $input['image'] = $image_name;
    
            // Create the activity list entry
            ActivityList::updateActivityList($id, $input);
            return redirect()->route('activity.index')->withStatus(__('Successfully Updated.'));
        }else{
            ActivityList::updateActivityList($id, $request->all());
            return redirect()->route('activity.index')->withStatus(__('Successfully Updated.'));
        }
    
        return redirect()->route('activity.index')->withError(__('Error.'));
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ActivityPage  $activityPage
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        ActivityHeader::deleteActivityHeader($id);
        return redirect()->route('activity.index')->withStatus(__('Deleted Successfully.'));
    }

    public function destroy_list($id)
    {
        //
        ActivityList::deleteActivityList($id);
        return redirect()->route('activity.index')->withStatus(__('Deleted Successfully.'));
    }
}
