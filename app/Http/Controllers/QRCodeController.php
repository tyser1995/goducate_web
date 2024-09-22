<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Crypt;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class QRCodeController extends Controller
{
    public function _generateQRCode($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        // Encrypt user details or any unique value to generate a secure QR code
        $encryptedData = Crypt::encryptString(json_encode([
            'user_id' => Hashids::encode($user->id),
            'name' => $user->name,
            'email' => $user->email
        ]));

        // $data = json_encode([
        //     'user_id' => $user->id,
        //     'name' => $user->name,
        //     'email' => $user->email
        // ]);

        // Generate the QR code
        // $qrCode = QrCode::size(400)->generate(Hashids::encode($user->id));
        $qrCode = QrCode::size(400)->generate($encryptedData);

        // $destination_path = public_path('/images/qrcode/');
    
        // // Check if the directory exists, if not, create it
        // if (!File::exists($destination_path)) {
        //     File::makeDirectory($destination_path, 0755, true);
        // }

        // $filePath = public_path($destination_path . Hashids::encode($user->id) . '.png');

        // QrCode::format('png')->size(300)->generate(Hashids::encode($user->id), $filePath);
    
        // return view('your-view', ['hashedId' => Hashids::encode($user->id)]);

        // Move the uploaded file to the destination path
        // $image_name = Hashids::encode($user->id) . '.png';
        // $image->move($destination_path, $image_name);

        // $filePath = public_path('images/' . Hashids::encode($user->id) . '.png');
        // Return view with QR code
        return view('pages.qrcode', compact('qrCode'));
        $fileName = 'qrcode_' . Hashids::encode($user->id) . '.png';
    }

    public function generateQRCode()
    {
       return view('pages.qrcode');
    }

    public function downloadQrCode(Request $request)
    {
        $user = User::find(6); // Or however you get the user

        // Prepare the data for the QR code
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
        //dd($qrData);

        try {
            // Decrypt the scanned data
            $decryptedData = Crypt::decryptString($qrData);
            $userDetails = json_decode($decryptedData, true);

            // Validate user information
            if (User::find(Hashids::decode($userDetails['user_id'])[0])) {
                return response()->json([
                    'success' => true]
                );
            } else {
                return response()->json(['success' => false, 'error' => 'Invalid user']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Decryption failed']);
        }

        //hasids
        // if (User::find(Hashids::decode($qrData)[0])) {
        //     return response()->json(['success' => true]);
        // } else {
        //     return response()->json(['success' => false, 'error' => 'Invalid user']);
        // }
    }
}
