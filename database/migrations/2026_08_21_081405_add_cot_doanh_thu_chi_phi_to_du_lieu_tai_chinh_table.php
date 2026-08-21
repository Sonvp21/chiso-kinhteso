<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('du_lieu_tai_chinh', function (Blueprint $table) {
            // 1. Doanh thu
            $table->decimal('tong_doanh_thu', 15, 2)->nullable()->after('nam');
            $table->decimal('dt_ha_tang_so', 15, 2)->nullable();
            $table->decimal('dt_nen_tang_so', 15, 2)->nullable();
            $table->decimal('dt_ung_dung_pm', 15, 2)->nullable();
            $table->decimal('dt_tmdt', 15, 2)->nullable();

            // 2. Chi phí
            $table->decimal('tong_chi_phi', 15, 2)->nullable();
            $table->decimal('cp_quang_cao', 15, 2)->nullable();
            $table->decimal('cp_duy_tri_web', 15, 2)->nullable();
            $table->decimal('cp_san_xuat_hang_hoa', 15, 2)->nullable();
            $table->decimal('cp_khac', 15, 2)->nullable();
            $table->decimal('cp_van_chuyen', 15, 2)->nullable();

            // 3. Giá trị gia tăng (bổ sung số thuế phải nộp)
            $table->decimal('so_thue_phai_nop', 15, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('du_lieu_tai_chinh', function (Blueprint $table) {
            $table->dropColumn([
                'tong_doanh_thu',
                'dt_ha_tang_so',
                'dt_nen_tang_so',
                'dt_ung_dung_pm',
                'dt_tmdt',
                'tong_chi_phi',
                'cp_quang_cao',
                'cp_duy_tri_web',
                'cp_san_xuat_hang_hoa',
                'cp_khac',
                'cp_van_chuyen',
                'so_thue_phai_nop',
            ]);
        });
    }
};
