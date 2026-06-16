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
        Schema::table('users', function (Blueprint $table) {
            $table->index(['role', 'prodi_asal'], 'users_role_prodi_asal_idx');
        });

        Schema::table('bimbingans', function (Blueprint $table) {
            $table->index(['mahasiswa_id', 'status'], 'bimbingans_mahasiswa_status_idx');
            $table->index(['dosen_id', 'status'], 'bimbingans_dosen_status_idx');
        });

        Schema::table('mahasiswa_dosen', function (Blueprint $table) {
            $table->index(['mahasiswa_id', 'dosen_id'], 'mahasiswa_dosen_composite_idx');
        });

        Schema::table('status_mahasiswa', function (Blueprint $table) {
            $table->index(['mahasiswa_id', 'layak_sempro', 'layak_sidang'], 'status_mhs_composite_idx');
        });

        Schema::table('submission_files', function (Blueprint $table) {
            $table->index(['bimbingan_id', 'status'], 'submissions_bimbingan_status_idx');
            $table->index(['mahasiswa_id', 'status'], 'submissions_mahasiswa_status_idx');
            $table->index(['dosen_id', 'status'], 'submissions_dosen_status_idx');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->index(['submission_id', 'dosen_id'], 'comments_submission_dosen_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_role_prodi_asal_idx');
        });

        Schema::table('bimbingans', function (Blueprint $table) {
            $table->dropIndex('bimbingans_mahasiswa_status_idx');
            $table->dropIndex('bimbingans_dosen_status_idx');
        });

        Schema::table('mahasiswa_dosen', function (Blueprint $table) {
            $table->dropIndex('mahasiswa_dosen_composite_idx');
        });

        Schema::table('status_mahasiswa', function (Blueprint $table) {
            $table->dropIndex('status_mhs_composite_idx');
        });

        Schema::table('submission_files', function (Blueprint $table) {
            $table->dropIndex('submissions_bimbingan_status_idx');
            $table->dropIndex('submissions_mahasiswa_status_idx');
            $table->dropIndex('submissions_dosen_status_idx');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropIndex('comments_submission_dosen_idx');
        });
    }
};
