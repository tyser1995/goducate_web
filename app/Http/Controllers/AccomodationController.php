<?php

namespace App\Http\Controllers;

use App\Models\Accomodation;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '_' . $image->getClientOriginalName();
            
            $destination_path = public_path('/images/accomodation/');
    
            // Check if the directory exists, if not, create it
            if (!File::exists($destination_path)) {
                File::makeDirectory($destination_path, 0755, true);
            }
    
            // Move the uploaded file to the destination path
            $image->move($destination_path, $image_name);
    
            // Add the image name to the request data
            $input = $request->all();
            $input['image'] = $image_name;
        }else{
            $input = $request->all();
            //$input['image'] = 'default-image.png';
        }

        Accomodation::createAccomodation($input);
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
        $input = $request->all();
        $accomodation = Accomodation::find($id);
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '_' . $image->getClientOriginalName();
            $destination_path = public_path('/images/accomodation/');
        
            // Ensure the directory exists
            if (!File::exists($destination_path)) {
                File::makeDirectory($destination_path, 0755, true);
            }
        
            $image->move($destination_path, $image_name);
            $input['image'] = $image_name;
        
            if ($accomodation->image && File::exists($destination_path . $accomodation->image)) {
                File::delete($destination_path . $accomodation->image);
            }
        } else {
            $input['image'] = $accomodation->image;
        }
        
        // Update the accomodation record with new or existing image
        $accomodation->update($input);
        
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
