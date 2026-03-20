<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentService
{
    /**
     * Record a manual payment upload from a customer.
     * Stores the attachment securely and creates a Payment record.
     */
    public function recordManualPayment(array $data, ?UploadedFile $attachment = null): Payment
    {
        $attachmentPath = null;

        if ($attachment) {
            $attachmentPath = $attachment->store('payments', 'local');
        }

        return Payment::create([
            'created_by_user_id' => Auth::id() ?? 0,
            'customer_id'        => $data['customer_id'],
            'amount'             => $data['amount'],
            'attachment'         => $attachmentPath,
            'payment_status'     => 'Partial',
        ]);
    }

    /**
     * Mark all payments for a customer as viewed.
     */
    public function markViewed(int $customerId): void
    {
        Payment::where('customer_id', $customerId)->update([
            'created_by_user_id' => Auth::id() ?? 0,
            'payment_status'     => 'Viewed by ' . (Auth::user()?->name ?? 'Admin'),
        ]);
    }

    /**
     * Update a payment record.
     */
    public function update(int $paymentId, array $data, ?UploadedFile $attachment = null): Payment
    {
        $payment = Payment::findOrFail($paymentId);

        $attachmentPath = $payment->attachment;
        if ($attachment) {
            if ($attachmentPath) {
                Storage::disk('local')->delete($attachmentPath);
            }
            $attachmentPath = $attachment->store('payments', 'local');
        }

        $payment->update([
            'created_by_user_id' => Auth::id() ?? 0,
            'customer_id'        => $data['customer_id'] ?? $payment->customer_id,
            'amount'             => $data['amount'] ?? $payment->amount,
            'attachment'         => $attachmentPath,
        ]);

        return $payment;
    }

    /**
     * Soft-delete a payment.
     */
    public function delete(int $paymentId): void
    {
        Payment::findOrFail($paymentId)->delete();
    }
}
