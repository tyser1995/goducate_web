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
        //Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            // Transaction::createTransaction($request->all());
            // $charge = Charge::create([
            //     'amount' => $request->amount * 1000, // Amount in cents
            //     'currency' => 'usd',
            //     'source' => $request->stripeToken,
            //     'description' => 'Payment from Laravel app',
            // ]);

            if ($request->hasFile('attachment')) {
                $image = $request->file('attachment');
                $image_name = $image->getClientOriginalName();
                
                $destination_path = public_path('/images/payment/');

                // Check if the directory exists, if not, create it
                if (!File::exists($destination_path)) {
                    File::makeDirectory($destination_path, 0755, true);
                }
                $image->move($destination_path, $image_name);

                $input = $request->all();
                $input['attachment'] = $image_name;
                $input['customer_id'] = Hashids::decode($request->customer_id)[0];
                Payment::createPayment($input);
                return redirect('/home');
            }
            return back()->withErrors('Error! ' . $e->getMessage());
           
        } catch (\Exception $e) {
            return back()->withErrors('Error! ' . $e->getMessage());
        }
    }
}
