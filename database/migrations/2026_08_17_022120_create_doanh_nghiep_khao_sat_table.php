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
        Schema::create('doanh_nghiep_khao_sat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedSmallInteger('nam');
            $table->string('ma_nganh', 20)->nullable(); // 26 | 46 | 58 | 62 | khac
            $table->unsignedInteger('so_luong_lao_dong')->nullable();
            $table->decimal('quy_mo_von', 15, 2)->nullable(); // tỷ đồng
            $table->string('loai_hinh_dn', 100)->nullable();
            $table->string('trang_thai', 20)->default('nhap'); // nhap | da_tinh
            $table->timestamp('ngay_nop')->nullable();
            $table->timestamps();
    
            $table->unique(['user_id', 'nam']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doanh_nghiep_khao_sat');
    }
};
