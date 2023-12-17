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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->string('photo_url')->nullable();
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('address');
            $table->string('city');
            $table->string('postal_code');
            $table->text('warning')->nullable();
            $table->string('phone');
            $table->string('email')->unique();
            $table->boolean('newsletter')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
