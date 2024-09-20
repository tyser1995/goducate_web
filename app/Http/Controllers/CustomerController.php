<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Vinkla\Hashids\Facades\Hashids;

class CustomerController extends Controller
{
    
    function __construct()
    {
        $this->middleware('permission:customer-list', ['only' => ['index']]);
        $this->middleware('permission:customer-create', ['only' => ['create','store']]);
        $this->middleware('permission:customer-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:customer-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customer.index',[
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
        return view('customer.create');
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
        if($request->input('password') == $request->input('confirm_password')){
            $check_user = User::where('email','=',$request->input('email'))
            ->get()
            ->first();

            if(!$check_user){
                $user = new User;
                $user->name = $request->input('first_name') .' '.$request->input('last_name');
                $user->email = $request->input('email');
                $user->password = Hash::make($request->input('password'));
                $user->role = 4;
                $user->save();

                CustomerModel::createCustomer($request->all());

                return redirect()->route('customer.index')->withStatus(__('Successfully created.'));
            }

            return redirect()->route('customer.index')->withError(__('Email already exists.'));
        }else{
            return redirect()->route('customer.create')->withError(__('Password does not match'));
        }

       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomerModel  $customerModel
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerModel $customerModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerModel  $customerModel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        return view('customer.edit',[
            'customers' => CustomerModel::getCustomerById(Hashids::decode($id)[0])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomerModel  $customerModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        CustomerModel::updateCustomer($id, $request->all());
        return redirect()->route('customer.index')->withStatus(__('Successfully Updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerModel  $customerModel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        CustomerModel::deleteCustomer($id);
        return redirect()->route('customer.index')->withError(__('Deleted successfully'));
    }
}
