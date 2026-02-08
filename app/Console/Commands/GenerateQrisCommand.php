<?php

namespace App\Console\Commands;

use App\Models\BankAccount;
use App\Services\QrisGeneratorService;
use Illuminate\Console\Command;

class GenerateQrisCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qris:generate';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Generate QRIS codes for all bank accounts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $qrisGenerator = app(QrisGeneratorService::class);
        $accounts = BankAccount::all();

        if ($accounts->isEmpty()) {
            $this->info('Tidak ada rekening bank untuk di-generate QRIS');
            return;
        }

        $this->withProgressBar($accounts, function ($account) use ($qrisGenerator) {
            $bankCode = $qrisGenerator->getBankCode($account->bank_name);
            $account->qris_path = $qrisGenerator->generateQrCode(
                $bankCode,
                $account->account_number,
                $account->merchant_name ?? $account->account_holder_name,
                $account->merchant_city ?? 'Indonesia'
            );
            $account->save();
        });

        $this->newLine();
        $this->info('QRIS berhasil di-generate untuk ' . count($accounts) . ' rekening bank');
    }
}
