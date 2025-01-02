<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class TransactionController extends Controller
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
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    public function showCheckoutForm()
    {
        return view('pages.checkout');
    }

    public function processPayment(Request $request)
    {
        try {
            if ($request->hasFile('attachment')) {
                $image = $request->file('attachment');
                
                // Generate a unique image name
                $image_name = uniqid() . '_' . $image->getClientOriginalName();
                // Define destination path
                $destination_path = public_path('/images/payment/');
            
                // Check if directory exists, if not, create it
                if (!File::exists($destination_path)) {
                    File::makeDirectory($destination_path, 0755, true);
                }
            
                // Move the image to the destination
                $image->move($destination_path, $image_name);
            
                // Create notification
                $notification = [
                    'created_by_user_id' =>  0,  // Consider replacing 0 with auth()->id() if applicable
                    'customer_id' => Hashids::decode($request->customer_id)[0],
                    'type' => 'payment',
                    'status' => 'pending',
                ];
            
                \App\Models\Notification::createNotification($notification);
            
                // Prepare input data for payment creation
                $input = $request->all();
                $input['attachment'] = $image_name;
                $input['customer_id'] = Hashids::decode($request->customer_id)[0];
                
                // Create payment record
                $data = Payment::createPayment($input);
            
                // Return success response
                return response()->json([
                    'success' => true,
                    'data' => $data,
                    'notification' =>$notification
                ], 200);
            }
            

            $notification = [
                'created_by_user_id' =>  0,
                'customer_id' => Hashids::decode($request->customer_id)[0],
                'type' => 'payment',
                'status' => 'pending',
            ];
            
            \App\Models\Notification::createNotification($notification);
            return back()->withErrors('Error! ' . $e->getMessage());
           
        } catch (\Exception $e) {
            return back()->withErrors('Error! ' . $e->getMessage());
        }
    }
}
