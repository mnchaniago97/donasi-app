<?php

namespace App\Console\Commands;

use App\Models\Donation;
use App\Mail\PaymentReceiptMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestPaymentEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test-payment {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test payment receipt email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? 'test@example.com';

        // Create a sample donation for testing
        $donation = Donation::create([
            'donor_name' => 'Test Donor',
            'donor_email' => $email,
            'donor_phone' => '08123456789',
            'amount' => 50000,
            'payment_method' => 'qris',
            'status' => 'success',
            'campaign_title' => 'Test Campaign',
            'transaction_id' => 'TEST-' . time(),
            'payment_completed_at' => now(),
        ]);

        try {
            Mail::to($email)->send(new PaymentReceiptMail($donation));
            $this->info("✓ Test payment email sent successfully to {$email}");
            
            // Clean up test record
            $donation->delete();
        } catch (\Exception $e) {
            $this->error("✗ Failed to send email: " . $e->getMessage());
            $donation->delete();
            return 1;
        }

        return 0;
    }
}
