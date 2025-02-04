<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('bpm_trunduhdokumen', function (Blueprint $table) {
            $table->id('udo_id');
            $table->unsignedBigInteger('dok_id');
            $table->unsignedBigInteger('rol_id')->nullable();
            $table->unsignedBigInteger('kry_id')->nullable();
            $table->string('rol_deskripsi', 255)->nullable();
            $table->boolean('udo_status_baca')->default(false);
            $table->string('udo_jenis_penyalinan', 50);
            $table->timestamp('udo_tgl_unduh')->nullable();
            $table->string('udo_status', 50)->nullable();
            $table->string('dok_ref', 255)->nullable();
            $table->string('udo_created_by', 50);
            $table->timestamp('udo_created_date')->nullable();
            $table->string('udo_modif_by', 50)->nullable();
            $table->timestamp('udo_modif_date')->nullable();
            
            // Foreign keys
            $table->foreign('dok_id')->references('id')->on('nama_tabel_dokumen')->onDelete('cascade');
            $table->foreign('rol_id')->references('id')->on('nama_tabel_role')->onDelete('cascade');
            $table->foreign('kry_id')->references('id')->on('nama_tabel_karyawan')->onDelete('cascade');
            $table->foreign('udo_created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('udo_modif_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bpm_trunduhdokumen');
    }
};