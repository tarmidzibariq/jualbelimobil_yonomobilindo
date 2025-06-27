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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            // relationship with users table
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');   

            $table->string('brand',50);
            $table->string('model',50);
            $table->string('year',5);
            $table->integer('price');
            $table->enum('transmission', ['manual', 'automatic']);
            $table->text('description')->nullable();
            $table->date('service_history')->nullable();
            $table->string('fuel_type',10);
            $table->string('mileage',10);
            $table->string('color',15);
            $table->date('tax');
            $table->integer('engine');
            $table->integer('seat');
            $table->boolean('bpkb');
            $table->boolean('spare_key');
            $table->boolean('manual_book');
            $table->boolean('service_book');
            $table->enum('sale_type',['user','showroom']);
            $table->enum('status',['available','pending_check','sold','under_review']);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
