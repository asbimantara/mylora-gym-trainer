<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trainer_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainer_profile_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('day_of_week'); // 0=Minggu, 1=Senin, ..., 6=Sabtu
            $table->time('start_hour'); // jam buka, misal 08:00
            $table->time('end_hour');   // jam tutup, misal 21:00
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trainer_availabilities');
    }
};
