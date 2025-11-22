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
        Schema::table('siswas', function (Blueprint $table) {
            // Change the column to a string to allow for longer values
            $table->string('jenis_kelamin')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            // Revert back to the ENUM type if needed
            // Note: This might cause data loss if values are not 'L' or 'P'
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->change();
        });
    }
};