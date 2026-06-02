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
        Schema::table('trainer_packages', function (Blueprint $table) {
            $table->integer('validity_days')->default(30)->after('session_count');
        });

        Schema::table('package_purchases', function (Blueprint $table) {
            $table->timestamp('expired_at')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trainer_packages', function (Blueprint $table) {
            $table->dropColumn('validity_days');
        });

        Schema::table('package_purchases', function (Blueprint $table) {
            $table->dropColumn('expired_at');
        });
    }
};
