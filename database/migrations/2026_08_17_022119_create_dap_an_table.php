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
        Schema::create('dap_an', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cau_hoi_id')->constrained('cau_hoi')->cascadeOnDelete();
            $table->string('noi_dung', 255);
            $table->decimal('diem_quy_doi', 8, 2)->default(0);
            $table->unsignedInteger('thu_tu')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dap_an');
    }
};
