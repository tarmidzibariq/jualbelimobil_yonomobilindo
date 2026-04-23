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
        Schema::create('otp_kodes', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 4);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('phone', 14);
            $table->dateTime('expires_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otp_kodes');
    }
};
