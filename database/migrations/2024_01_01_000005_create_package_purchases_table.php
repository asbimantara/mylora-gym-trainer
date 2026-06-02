<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // member
            $table->foreignId('trainer_package_id')->constrained()->onDelete('cascade');
            $table->foreignId('trainer_profile_id')->constrained()->onDelete('cascade');
            $table->integer('sessions_total');
            $table->integer('sessions_used')->default(0);
            $table->string('status')->default('pending'); // pending, active, completed, cancelled
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_purchases');
    }
};
