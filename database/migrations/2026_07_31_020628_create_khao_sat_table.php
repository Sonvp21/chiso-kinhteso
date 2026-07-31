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
        Schema::create('khao_sat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // doanh nghiệp
            $table->foreignId('bo_chi_so_phien_ban_id')->constrained('bo_chi_so_phien_ban')->cascadeOnDelete();
            $table->string('trang_thai', 20)->default('nhap'); // nhap | da_nop | da_tinh
            $table->timestamp('ngay_nop')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khao_sat');
    }
};
