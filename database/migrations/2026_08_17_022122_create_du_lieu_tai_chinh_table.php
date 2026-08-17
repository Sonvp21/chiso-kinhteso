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
        Schema::create('du_lieu_tai_chinh', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doanh_nghiep_khao_sat_id')->constrained('doanh_nghiep_khao_sat')->cascadeOnDelete();
            $table->unsignedSmallInteger('nam'); // 2021-2025
            $table->decimal('khau_hao_tscd', 15, 2)->nullable(); // tỷ đồng
            $table->decimal('thu_nhap_lao_dong', 15, 2)->nullable();
            $table->decimal('thu_nhap_dn', 15, 2)->nullable();
            $table->timestamps();
    
            $table->unique(['doanh_nghiep_khao_sat_id', 'nam']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('du_lieu_tai_chinh');
    }
};
