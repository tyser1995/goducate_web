<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessPermit;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;

class BusinessPermitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $business_permit = BusinessPermit::get();

        return view('business_permit.index',[
            'business_permits' => $business_permit
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
        return view('business_permit.create');
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

        $permit = implode(',', $request->input('permit', []));

        $business_permit = BusinessPermit::where('business_name',$request->business_name)
        ->first();

        if(empty($business_permit)){
            $business_permit = new BusinessPermit;
        }else{
            return redirect()->route('business_permit.create')->withError(__('Business Name '. $request->business_name. ' already created.'));
        }
        
        $business_permit->created_by_user_id = Auth::user()->id;
        $business_permit->business_name = $request->business_name;
        $business_permit->type = $request->type;
        $business_permit->permit = $permit;
        $business_permit->save();
        return redirect()->route('business_permits')->withStatus(__('Successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BusinessPermit $business_permit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BusinessPermit $business_permit)
    {
        //
        $dbOptions = $business_permit->permit;
        $options = ['mayor_permit', 'brgy_permit']; // Example opt
        return view('business_permit.edit',[
            'business_permit' => $business_permit,
            'dbOptions' => $dbOptions,
            'options' => $options
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BusinessPermit $business_permit)
    {
        //
        $permit = implode(',', $request->input('permit', []));
        $business_permit = BusinessPermit::find($business_permit->id);
        if(empty($business_permit)){
            $consumer_rights = new BusinessPermit;
        }
        $business_permit->business_name = $request->business_name;
        $business_permit->type = $request->type;
        $business_permit->permit = $permit;
        $business_permit->save();
        
        return redirect()->route('business_permits')->withStatus(__('Successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessPermit $business_permit)
    {
        //
    }
}
