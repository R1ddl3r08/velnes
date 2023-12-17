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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->onDelete('cascade');
            $table->foreignId('employee_id')->onDelete('cascade');
            $table->foreignId('customer_id')->onDelete('cascade');
            $table->foreignId('tool_1_id')->onDelete('cascade');
            $table->foreignId('tool_2_id')->nullable()->onDelete('cascade');
            $table->foreignId('room_id')->onDelete('cascade');
            $table->string('duration');
            $table->dateTime('date_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
