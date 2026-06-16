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
        Schema::table('schedule_periods', function (Blueprint $table) {
            // Tambah kolom jenis untuk kategori: Sempro, Semhas, Sidang Skripsi
            $table->string('jenis')->default('Sempro')->after('period_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedule_periods', function (Blueprint $table) {
            $table->dropColumn('jenis');
        });
    }
};
