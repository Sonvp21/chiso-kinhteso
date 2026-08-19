<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nhat_ky_thao_tac', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('hanh_dong', 20); // tao | sua | xoa | nop
            $table->string('doi_tuong', 50); // ten bang/model
            $table->unsignedBigInteger('doi_tuong_id')->nullable();
            $table->text('mo_ta')->nullable();
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('nhat_ky_thao_tac');
    }
};
