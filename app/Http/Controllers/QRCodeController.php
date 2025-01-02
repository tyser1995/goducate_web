<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\QRCodeModel;
use App\Models\Reports;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Crypt;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image as Image;

class QRCodeController extends Controller
{
    public function index(){
        return view('qrcode.index',[
            'qrcodes' => QRCodeModel::getQRCode()
        ]);
    }

    public function show(){
        
    }

    public function create(){
        return view('qrcode.create');
    }
    
    public function store(Request $request){
        
    }

    public function edit($id){
        
    }

    public function update(Request $request){
        
    }

    public function updateFunds(Request $request)
    {
        $qrcode = QRCodeModel::findOrFail($request->id);
        $qrcode->amount += $request->funds;
        $qrcode->save();

        return response()->json([
            'message' => 'Funds added successfully!'
        ]);
    }

    public function destroy($id){
        QRCodeModel::deleteQRCode($id);
        return redirect()->route('qrcode.index')->withError(__('Deleted Successfully.'));
    }

    public function _generateQRCode(Request $request) 
    {
        $encryptedData = Crypt::encryptString(json_encode([
            'number' => Hashids::encode($request->number),
        ]));

        $qrCode = QrCode::size(400)->generate($encryptedData);

        $input = $request->all();
        $input['qrcode_generated'] = $encryptedData; 
        QRCodeModel::createQRCode($input);

        return redirect()->route('qrcode.index')->withStatus(__('Created Successfully.'));
    }

    public function generateQRCode()
    {
       return view('pages.qrcode');
    }

    //test function
    public function downloadQrCode(Request $request)
    {
        $user = User::find(6);
        $data = json_encode([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ]);

        // Generate the QR code as an image
        $qrCodeImage = QrCode::format('png')->size(300)->generate(Hashids::encode($user->id));

        // Define the file name
        $fileName = 'qrcode_' . Hashids::encode($user->id) . '.png';

        // Return the QR code image as a downloadable response
        return response($qrCodeImage)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }


    public function verifyQRCode(Request $request)
    {
        $qrData = $request->input('qr_data');

        try {
            $qrcode = QRCodeModel::where('qrcode_generated', '=', $qrData)->first();

            if (!$qrcode) {
                return response()->json([
                    'success' => false,
                    'error' => 'Invalid QR code'
                ]);
            }

            $deductionAmount = 1; // Set the amount to deduct
            if ($qrcode->amount < $deductionAmount) {
                return response()->json([
                    'success' => false,
                    'error' => 'Insufficient funds'
                ]);
            }

            $qrcode->amount -= $deductionAmount;
            $qrcode->save();

            //Report QR Code scanner
            Reports::createReports($request->all());
            return response()->json([
                'message' => 'Successfully deducted.',
                'success' => true
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'An error occurred: ' . $e->getMessage()
            ]);
        }
    }

}
