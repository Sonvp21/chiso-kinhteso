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
        Schema::dropIfExists('ket_qua');
        Schema::dropIfExists('khao_sat_chi_tiet');
        Schema::dropIfExists('khao_sat');
        Schema::dropIfExists('chi_so');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
