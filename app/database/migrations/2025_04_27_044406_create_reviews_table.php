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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('sales_record_id')->nullable()->constrained('sales_records')->onDelete('cascade');
            $table->foreignId('car_id')->nullable()->constrained('cars')->onDelete('cascade');
            $table->integer('rating')->nullable()->default(5);
            $table->text('comment')->nullable();
            $table->string('photo_review')->nullable();
            // $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }    
};
