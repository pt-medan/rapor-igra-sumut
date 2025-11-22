<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            $table->unsignedInteger('student_quota')->default(0)->after('alamat')->comment('Maximum number of students this guru can add');
            $table->unsignedInteger('student_count')->default(0)->after('student_quota')->comment('Current number of students added by this guru');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            $table->dropColumn(['student_quota', 'student_count']);
        });
    }
};
