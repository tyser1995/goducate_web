<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Payment;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\AddPaymentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Crypt;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class CustomerController extends Controller
{
    
    function __construct()
    {
        // $this->middleware('permission:customer-list', ['only' => ['index']]);
        // $this->middleware('permission:customer-create', ['only' => ['create','store']]);
        // $this->middleware('permission:customer-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:customer-delete', ['only' => ['destroy']]);
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
    public function store(StoreCustomerRequest $request)
    {
        $data = $request->validated();

        $check_user = User::where('email', $data['email'])->first();
        if ($check_user) {
            return redirect()->route('customer.index')->withError(__('Email already exists.'));
        }

        $user = new User;
        $user->name     = $data['first_name'] . ' ' . $data['last_name'];
        $user->email    = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->role     = 4;
        $user->save();

        CustomerModel::createCustomer($data);

        return redirect()->route('customer.index')->withStatus(__('Successfully created.'));
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

    public function generateQrCode($id)
    {
        $user = CustomerModel::find(Hashids::decode($id)[0]);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.']);
        }

        $encryptedData = Crypt::encryptString(json_encode([
            'user_id' => Hashids::encode($user->id),
            'email' => $user->email
        ]));

      
        $qrCode = QrCode::size(400)->generate($encryptedData);

      
        return view('customer.qrcode', compact('qrCode'));
        $fileName = 'qrcode_' . Hashids::encode($user->id) . '.png';
    }

    public function getPayments($id){
        $customer = CustomerModel::find(Hashids::decode($id)[0]);
        $transaction = Transaction::getTransaction(Hashids::decode($id)[0]);
       
        Payment::updatePaymentStatus(Hashids::decode($id)[0]);
        
        \App\Models\Notification::updateNotificationStatus(Hashids::decode($id)[0],'payment');
        return view('customer.payment',[
            'customers'     => $customer,
            'transactions'  => $transaction
        ]);
    }

    public function getVerifyPayments($id){
        $customer = CustomerModel::find(Hashids::decode($id)[0]);
        if(!$customer){
            return redirect()->back()->withErrors('No customer found')->withInput();
        }
    }

    public function getCustomerPrintAndDelete(Request $request){
        $customerId = $request->input('customer_id');
        $transaction = Transaction::deleteTransactionAfterPrint($customerId);
        return response()->json([
            'success' => true,
            'deleted_count' => $transaction,
        ], 200);
    }

    public function addPayments(AddPaymentRequest $request)
    {
        Transaction::createTransaction($request->validated());
        return redirect()->route('customer.payment', Hashids::encode($request->validated()['customer_id']))->withStatus(__('Created successfully'));
    }
}
