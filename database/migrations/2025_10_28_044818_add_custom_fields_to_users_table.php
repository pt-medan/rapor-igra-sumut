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
            $table->foreignId('sekolah_id')->nullable()->after('id')->constrained('sekolahs')->onDelete('set null');
            $table->enum('role', ['admin_provinsi', 'admin_kabupaten', 'guru'])->default('guru')->after('email');
            $table->enum('status', ['pending', 'active', 'inactive'])->default('pending')->after('role');
            $table->timestamp('validated_at')->nullable()->after('status');
            $table->foreignId('validated_by')->nullable()->after('validated_at')->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['sekolah_id']);
            $table->dropForeign(['validated_by']);
            $table->dropColumn(['sekolah_id', 'role', 'status', 'validated_at', 'validated_by']);
        });
    }
};
