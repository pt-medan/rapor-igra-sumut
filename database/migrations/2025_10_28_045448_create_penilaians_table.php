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
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->string('tahun_ajaran', 9);
            $table->enum('semester', ['1', '2']);

            // Aspek Penilaian
            $table->text('agama_budi_pekerti')->nullable();
            $table->text('jati_diri')->nullable();
            $table->text('literasi_sains')->nullable();

            // Kehadiran
            $table->unsignedSmallInteger('sakit')->default(0);
            $table->unsignedSmallInteger('izin')->default(0);
            $table->unsignedSmallInteger('tanpa_keterangan')->default(0);

            // Catatan
            $table->text('catatan_kesehatan')->nullable();
            $table->text('catatan_guru')->nullable();

            // Ekstrakurikuler (simple implementation)
            $table->string('ekskul_1_nama')->nullable();
            $table->string('ekskul_1_nilai')->nullable();
            $table->string('ekskul_2_nama')->nullable();
            $table->string('ekskul_2_nilai')->nullable();

            $table->timestamps();

            // A student can only have one report card per semester per academic year
            $table->unique(['siswa_id', 'tahun_ajaran', 'semester']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
