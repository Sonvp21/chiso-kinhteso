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
        Schema::create('tra_loi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doanh_nghiep_khao_sat_id')->constrained('doanh_nghiep_khao_sat')->cascadeOnDelete();
            $table->foreignId('cau_hoi_id')->constrained('cau_hoi')->cascadeOnDelete();
            $table->foreignId('dap_an_id')->nullable()->constrained('dap_an')->cascadeOnDelete();
            $table->decimal('gia_tri_so', 15, 2)->nullable(); // dùng khi cau_hoi.loai = 'so'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tra_loi');
    }
};
