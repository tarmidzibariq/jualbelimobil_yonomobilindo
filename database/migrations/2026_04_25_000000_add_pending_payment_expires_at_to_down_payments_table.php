<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('down_payments', function (Blueprint $table) {
            $table->dateTime('pending_payment_expires_at')->nullable()->after('payment_date');
        });

        // DP pending lama: tenggat = created_at + 10 menit (bisa langsung kedaluwarsa jika sudah lama).
        $pending = DB::table('down_payments')
            ->where('payment_status', 'pending')
            ->whereNull('pending_payment_expires_at')
            ->get(['id', 'created_at']);

        foreach ($pending as $row) {
            DB::table('down_payments')
                ->where('id', $row->id)
                ->update([
                    'pending_payment_expires_at' => Carbon::parse($row->created_at)->addMinutes(10),
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('down_payments', function (Blueprint $table) {
            $table->dropColumn('pending_payment_expires_at');
        });
    }
};
