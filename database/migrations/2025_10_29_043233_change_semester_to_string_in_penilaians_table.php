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
            // Change the column to a string to allow for 'Ganjil' and 'Genap'
            $table->string('semester', 10)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penilaians', function (Blueprint $table) {
            // Revert back to the ENUM type if needed
            // Note: This will fail if the data is not '1' or '2'. 
            // A more robust down migration would handle data conversion first.
            $table->enum('semester', ['1', '2'])->change();
        });
    }
};