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
        Schema::table('penilaians', function (Blueprint $table) {
            // Add the new flexible JSON column
            $table->json('ekstrakurikuler')->nullable()->after('catatan_guru');

            // Remove the old rigid columns
            $table->dropColumn([
                'ekskul_1_nama',
                'ekskul_1_nilai',
                'ekskul_2_nama',
                'ekskul_2_nilai',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penilaians', function (Blueprint $table) {
            // Re-add the old columns if we roll back
            $table->string('ekskul_1_nama')->nullable();
            $table->string('ekskul_1_nilai')->nullable();
            $table->string('ekskul_2_nama')->nullable();
            $table->string('ekskul_2_nilai')->nullable();

            // Drop the new JSON column
            $table->dropColumn('ekstrakurikuler');
        });
    }
};