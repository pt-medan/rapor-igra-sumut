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
            $table->foreignId('kelompok_kelas_id')->nullable()->constrained('kelompok_kelas')->onDelete('set null');
            $table->string('nama_kelompok_kelas_baru')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['kelompok_kelas_id']);
            $table->dropColumn(['kelompok_kelas_id', 'nama_kelompok_kelas_baru']);
        });
    }
};
