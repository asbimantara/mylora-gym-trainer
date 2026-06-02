<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trainer_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainer_profile_id')->constrained()->onDelete('cascade');
            $table->string('name'); // "Paket 8 Sesi", "Paket 12 Sesi"
            $table->integer('session_count'); // 1, 8, 10, 12, 16, 20
            $table->decimal('price', 12, 2); // total harga paket
            $table->text('description')->nullable();
            $table->text('benefits')->nullable(); // JSON or comma-separated
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trainer_packages');
    }
};
