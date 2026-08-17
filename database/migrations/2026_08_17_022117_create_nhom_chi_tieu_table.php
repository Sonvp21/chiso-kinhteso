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
        Schema::create('nhom_chi_tieu', function (Blueprint $table) {
            $table->id();
            $table->string('ma', 20)->unique();
            $table->string('ten', 255);
            $table->text('mo_ta')->nullable();
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
        Schema::dropIfExists('nhom_chi_tieu');
    }
};
