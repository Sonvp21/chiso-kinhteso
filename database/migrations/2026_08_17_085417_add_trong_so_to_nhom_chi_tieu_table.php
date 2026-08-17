<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nhom_chi_tieu', function (Blueprint $table) {
            $table->decimal('trong_so', 5, 4)->default(0)->after('thu_tu');
        });
    }
    
    public function down(): void
    {
        Schema::table('nhom_chi_tieu', function (Blueprint $table) {
            $table->dropColumn('trong_so');
        });
    }
};
