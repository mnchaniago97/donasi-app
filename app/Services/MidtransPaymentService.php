<?php

namespace App\Services;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Donation;
use App\Mail\PaymentReceiptMail;
use Illuminate\Support\Facades\Mail;

class MidtransPaymentService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.environment') === 'production';
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Buat payment token untuk QRIS atau Bank Transfer
     */
    public function createPaymentToken(Donation $donation): ?string
    {
        try {
            $payload = [
                'transaction_details' => [
                    'order_id' => $donation->id . '-' . time(),
                    'gross_amount' => (int) $donation->amount,
                ],
                'customer_details' => [
                    'first_name' => $donation->donor_name,
                    'email' => $donation->donor_email,
                    'phone' => $donation->donor_phone ?? '08000000000',
                ],
                'item_details' => [
                    [
                        'id' => 'donation-' . $donation->id,
                        'price' => (int) $donation->amount,
                        'quantity' => 1,
                        'name' => $donation->campaign_title ?? 'Donasi',
                    ],
                ],
                'enabled_payments' => $this->getEnabledPaymentMethods($donation->payment_method),
                'expiry' => [
                    'unit' => 'minutes',
                    'length' => 60,
                ],
            ];

            $response = Snap::createTransaction($payload);

            return $response->token ?? null;
        } catch (\Exception $e) {
            \Log::error('Midtrans Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Dapatkan Snap URL untuk pembayaran
     */
    public function getSnapUrl(Donation $donation): ?string
    {
        try {
            $payload = [
                'transaction_details' => [
                    'order_id' => $donation->id . '-' . time(),
                    'gross_amount' => (int) $donation->amount,
                ],
                'customer_details' => [
                    'first_name' => $donation->donor_name,
                    'email' => $donation->donor_email,
                    'phone' => $donation->donor_phone ?? '08000000000',
                ],
                'item_details' => [
                    [
                        'id' => 'donation-' . $donation->id,
                        'price' => (int) $donation->amount,
                        'quantity' => 1,
                        'name' => $donation->campaign_title ?? 'Donasi',
                    ],
                ],
                'enabled_payments' => $this->getEnabledPaymentMethods($donation->payment_method),
            ];

            $response = Snap::createTransaction($payload);

            return $response->redirect_url ?? null;
        } catch (\Exception $e) {
            \Log::error('Midtrans Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Verifikasi status pembayaran
     */
    public function verifyPayment(string $orderId)
    {
        try {
            return \Midtrans\Transaction::status($orderId);
        } catch (\Exception $e) {
            \Log::error('Midtrans Verification Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Handle notification dari Midtrans (webhook)
     */
    public function handleNotification($notificationPayload)
    {
        try {
            $status = \Midtrans\Transaction::status($notificationPayload->order_id);

            $donation = Donation::where('transaction_id', $notificationPayload->order_id)->first();

            if (!$donation) {
                return [
                    'success' => false,
                    'message' => 'Donation not found',
                ];
            }

            if ($status->transaction_status == 'capture' || $status->transaction_status == 'settlement') {
                $donation->update([
                    'status' => 'success',
                    'payment_completed_at' => now(),
                ]);

                // Kirim email bukti pembayaran
                try {
                    Mail::to($donation->donor_email)->send(new PaymentReceiptMail($donation));
                } catch (\Exception $e) {
                    \Log::error('Failed to send payment receipt email: ' . $e->getMessage());
                }

                return [
                    'success' => true,
                    'message' => 'Payment confirmed',
                ];
            } elseif ($status->transaction_status == 'pending') {
                $donation->update(['status' => 'pending']);
                return ['success' => true, 'message' => 'Payment pending'];
            } elseif ($status->transaction_status == 'deny' || $status->transaction_status == 'cancel' || $status->transaction_status == 'expire') {
                $donation->update(['status' => 'failed']);
                return ['success' => true, 'message' => 'Payment failed'];
            }

            return ['success' => true, 'message' => 'Status updated'];
        } catch (\Exception $e) {
            \Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Tentukan payment method yang diaktifkan
     */
    private function getEnabledPaymentMethods(?string $paymentMethod): array
    {
        $methods = [];

        if ($paymentMethod === 'qris' || $paymentMethod === null) {
            $methods[] = 'qris';
        }

        if ($paymentMethod === 'bank_transfer' || $paymentMethod === null) {
            $methods[] = 'bank_transfer';
        }

        return !empty($methods) ? $methods : ['qris', 'bank_transfer'];
    }
}
