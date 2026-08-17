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
        Schema::create('cau_hoi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nhom_chi_tieu_id')->constrained('nhom_chi_tieu')->cascadeOnDelete();
            $table->string('ma', 20)->unique();
            $table->text('noi_dung');
            $table->string('loai', 20)->default('chon_1'); // chon_1 | chon_nhieu | so
            $table->unsignedInteger('thu_tu')->default(0);
            $table->boolean('kich_hoat')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cau_hoi');
    }
};
