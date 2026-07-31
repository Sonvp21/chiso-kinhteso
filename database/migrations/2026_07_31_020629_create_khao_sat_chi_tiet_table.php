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
        Schema::create('khao_sat_chi_tiet', function (Blueprint $table) {
            $table->id();
            $table->foreignId('khao_sat_id')->constrained('khao_sat')->cascadeOnDelete();
            $table->foreignId('chi_so_id')->constrained('chi_so')->cascadeOnDelete();
            $table->decimal('gia_tri_nhap', 15, 4)->nullable(); // giá trị thô doanh nghiệp nhập
            $table->timestamps();
    
            $table->unique(['khao_sat_id', 'chi_so_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khao_sat_chi_tiet');
    }
};
