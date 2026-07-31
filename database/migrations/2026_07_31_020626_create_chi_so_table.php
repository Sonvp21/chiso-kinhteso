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
        Schema::create('chi_so', function (Blueprint $table) {
            $table->id();
            $table->string('ma_chi_so', 20)->unique(); // vd: DE01
            $table->string('ten_chi_so', 255);
            $table->string('nhom', 100); // vd: Hạ tầng số, Doanh nghiệp số...
            $table->string('don_vi_tinh', 50)->nullable(); // %, điểm...
            $table->text('cong_thuc')->nullable(); // mô tả công thức chuẩn hóa
            $table->decimal('trong_so', 5, 4)->default(0); // vd 0.2000
            $table->text('nguon_du_lieu')->nullable();
            $table->text('nguong_danh_gia')->nullable();
            $table->text('ghi_chu')->nullable();
            $table->boolean('kich_hoat')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_so');
    }
};
