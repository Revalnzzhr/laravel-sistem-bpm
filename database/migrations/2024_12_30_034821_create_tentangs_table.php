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
        Schema::create('bpm_tentang', function (Blueprint $table) {
            $table->id();
            $table->string('ten_category');
            $table->text('ten_isi');
            $table->string('ten_status');
            $table->string('ten_created_by');
            $table->timestamp('ten_created_date');
            $table->string('ten_modif_by')->nullable();
            $table->timestamp('ten_modif_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bpm_tentang');
    }
};
