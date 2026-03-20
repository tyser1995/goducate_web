<?php

namespace App\Services;

use App\Models\PushSubscription;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class PushNotificationService
{
    private WebPush $webPush;

    public function __construct()
    {
        $this->webPush = new WebPush([
            'VAPID' => [
                'publicKey'  => config('services.vapid.public_key'),
                'privateKey' => config('services.vapid.private_key'),
                'subject'    => config('services.vapid.subject'),
            ],
        ]);
    }

    public function sendToSubscription(PushSubscription $subscription, array $payload): void
    {
        $this->webPush->sendOneNotification(
            Subscription::create(json_decode($subscription->data, true)),
            json_encode($payload)
        );
    }

    public function sendToAll(array $payload): void
    {
        foreach (PushSubscription::all() as $subscription) {
            $this->webPush->queueNotification(
                Subscription::create(json_decode($subscription->data, true)),
                json_encode($payload)
            );
        }

        foreach ($this->webPush->flush() as $report) {
            if ($report->isSubscriptionExpired()) {
                PushSubscription::where('endpoint', $report->getRequest()->getUri()->__toString())->delete();
            }
        }
    }
}
