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
        Schema::create('bo_chi_so_phien_ban', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('nam'); // vd 2025, 2026
            $table->string('ten_phien_ban', 150)->nullable(); // vd "Phiên bản 2025"
            $table->boolean('dang_ap_dung')->default(false);
            $table->timestamps();
    
            $table->unique('nam');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bo_chi_so_phien_ban');
    }
};
