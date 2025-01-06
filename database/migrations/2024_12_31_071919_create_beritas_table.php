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
        Schema::create('bpm_msberita', function (Blueprint $table) {
            $table->id('ber_id');
            $table->string('ber_judul', 100)->nullable();
            $table->dateTime('ber_tgl')->nullable();
            $table->string('ber_penulis', 100)->nullable();
            $table->text('ber_isi')->nullable();
            $table->string('ber_foto1')->nullable();
            $table->string('ber_foto2')->nullable();
            $table->string('ber_foto3')->nullable();
            $table->string('ber_status', 15)->nullable();
            $table->string('ber_created_by', 50)->nullable();
            $table->dateTime('ber_created_date')->nullable();
            $table->string('ber_modif_by', 50)->nullable();
            $table->dateTime('ber_modif_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bpm_msberita');
    }
};
