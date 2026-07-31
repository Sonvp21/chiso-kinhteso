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
        Schema::create('ket_qua', function (Blueprint $table) {
            $table->id();
            $table->foreignId('khao_sat_id')->constrained('khao_sat')->cascadeOnDelete();
            $table->json('chi_tiet_diem')->nullable(); // snapshot điểm từng chỉ số (chuẩn hóa + trọng số)
            $table->json('diem_theo_nhom')->nullable(); // snapshot điểm từng nhóm chỉ số
            $table->decimal('diem_tong_hop', 6, 2)->nullable();
            $table->string('muc_danh_gia', 20)->nullable(); // Thấp | Trung bình | Khá | Tốt
            $table->timestamp('tinh_luc')->nullable();
            $table->timestamps();
    
            $table->unique('khao_sat_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ket_qua');
    }
};
