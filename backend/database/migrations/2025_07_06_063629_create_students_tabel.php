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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->unique();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('profile_picture')->nullable();
            $table->unsignedBigInteger('trade_id')->nullable();
            $table->string('gender')->nullable();
            $table->string('state')->nullable();
            $table->timestamp('mobile_verified_at')->nullable(); 
            $table->boolean('completed_profile')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
