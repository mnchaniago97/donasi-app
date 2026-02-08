<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\BankAccount;
use App\Services\MidtransPaymentService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class DonationController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransPaymentService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Tampilkan form donasi
     */
    public function create()
    {
        $bankAccounts = BankAccount::active()->get();
        return view('donations.create', compact('bankAccounts'));
    }

    /**
     * Simpan donasi baru
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email',
            'donor_phone' => 'nullable|string|max:20',
            'amount' => 'required|numeric|min:10000',
            'campaign_title' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:qris,bank_transfer,dana,gopay',
        ]);

        $donation = Donation::create($validated);

        // Generate payment token via Midtrans (hanya untuk QRIS)
        if ($donation->payment_method === 'qris') {
            $paymentToken = $this->midtransService->createPaymentToken($donation);
            if ($paymentToken) {
                $donation->update(['payment_token' => $paymentToken]);
            }
        }

        return redirect()->route('donations.payment', $donation);
    }

    /**
     * Tampilkan halaman pembayaran
     */
    public function payment(Donation $donation)
    {
        if ($donation->status !== 'pending') {
            return redirect()->route('donations.show', $donation);
        }

        $snapUrl = $this->midtransService->getSnapUrl($donation);
        $bankAccounts = BankAccount::active()->get();

        return view('donations.payment', compact('donation', 'snapUrl', 'bankAccounts'));
    }

    /**
     * Tampilkan detail donasi dan status pembayaran
     */
    public function show(Donation $donation)
    {
        return view('donations.show', compact('donation'));
    }

    /**
     * Handle webhook dari Midtrans
     */
    public function handleNotification(Request $request)
    {
        $notificationPayload = $request->all();

        $result = $this->midtransService->handleNotification((object) $notificationPayload);

        return response()->json($result);
    }

    /**
     * Cek status pembayaran
     */
    public function checkStatus(Donation $donation)
    {
        if ($donation->status === 'pendingx' && $donation->payment_token) {
            // Verifikasi status ke Midtrans
            $status = $this->midtransService->verifyPayment($donation->transaction_id ?? $donation->id);

            if ($status && ($status->transaction_status == 'capture' || $status->transaction_status == 'settlement')) {
                $donation->update([
                    'status' => 'success',
                    'payment_completed_at' => now(),
                ]);
            }
        }

        return response()->json([
            'status' => $donation->status,
            'donation' => $donation,
        ]);
    }

    /**
     * Daftar semua donasi sukses
     */
    public function listSuccess()
    {
        $donations = Donation::completed()
            ->orderByDesc('payment_completed_at')
            ->paginate(20);

        return view('donations.list', compact('donations'));
    }

    /**
     * Dashboard statistik donasi
     */
    public function dashboard()
    {
        $totalDonations = Donation::completed()->count();
        $totalAmount = Donation::completed()->sum('amount');
        $recentDonations = Donation::completed()->orderByDesc('payment_completed_at')->limit(10)->get();

        return view('donations.dashboard', compact('totalDonations', 'totalAmount', 'recentDonations'));
    }
}
