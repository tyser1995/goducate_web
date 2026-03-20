<?php

namespace App\Http\Controllers;

use App\Models\PushSubscription;
use App\Services\PushNotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(private PushNotificationService $pushService)
    {
    }

    public function index()
    {
        return view('notify', [
            'subscriptions' => PushSubscription::all(),
        ]);
    }

    public function sendAlert(PushSubscription $sub, Request $request)
    {
        $this->pushService->sendToSubscription($sub, $request->input());

        return response()->json(['success' => true]);
    }

    public function sendToSubscriber(PushSubscription $sub, Request $request)
    {
        $this->pushService->sendToSubscription($sub, $request->input());

        return response()->json(['success' => true]);
    }

    public function broadcast(Request $request)
    {
        $this->pushService->sendToAll($request->input());

        return response()->json(['success' => true]);
    }
}
