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
            $table->string('role', 20)->default('doanh_nghiep')->after('email'); // 'quan_tri' | 'doanh_nghiep'
            $table->foreignId('xa_phuong_id')->nullable()->after('role')->constrained('xa_phuong')->nullOnDelete();
            $table->string('ten_doanh_nghiep', 200)->nullable()->after('xa_phuong_id');
            $table->string('mst', 20)->nullable()->after('ten_doanh_nghiep'); // mã số thuế
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('xa_phuong_id');
            $table->dropColumn(['role', 'ten_doanh_nghiep', 'mst']);
        });
    }
};
