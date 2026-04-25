<?php

namespace App\Console\Commands;

use App\Models\DownPayment;
use Illuminate\Console\Command;

class ExpirePendingDownPayments extends Command
{
    protected $signature = 'down-payments:expire-pending';

    protected $description = 'Batalkan DP pending yang melewati batas waktu pembayaran';

    public function handle(): int
    {
        $count = DownPayment::cancelExpiredPendingPayments();
        if ($count > 0) {
            $this->info("Dibatalkan: {$count} down payment.");
        }

        return self::SUCCESS;
    }
}
