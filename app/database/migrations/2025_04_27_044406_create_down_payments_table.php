<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('down_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('car_id')->constrained('cars')->onDelete('cascade');
            $table->string('order_id', 100)->unique()->nullable();
            $table->decimal('amount', 15, 2);
            $table->enum('payment_status', ['pending', 'confirmed', 'cancelled', 'expired'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->dateTime('appointment_date');
            $table->dateTime('payment_date')->nullable();
            // $table->string('payment_proof')->nullable();
            $table->string('snap_token', 255)->unique()->nullable();

            // Perbaikan foreign key refund_id
            $table->unsignedBigInteger('refund_id')->nullable();
            $table->foreign('refund_id')->references('id')->on('refunds')->onDelete('set null');

            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('down_payments');
    }
};
