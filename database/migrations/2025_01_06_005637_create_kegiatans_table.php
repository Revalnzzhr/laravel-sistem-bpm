<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('bpm_mskegiatan', function (Blueprint $table) {
            $table->id('keg_id');
            $table->foreignId('jkg_id')
                ->constrained('bpm_msJenisKegiatan', 'jkg_id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('keg_kategori', 15)->nullable();
            $table->string('keg_nama', 120)->nullable();
            $table->text('keg_deskripsi')->nullable();
            $table->date('keg_tgl_mulai')->nullable();
            $table->time('keg_jam_mulai')->nullable();
            $table->date('keg_tgl_selesai')->nullable();
            $table->time('keg_jam_selesai')->nullable();
            $table->string('keg_tempat', 100)->nullable();
            $table->text('keg_foto_sampul')->nullable();
            $table->text('keg_link_folder')->nullable();
            $table->text('keg_dok_notulen')->nullable();
            $table->string('keg_status_dok_notulen', 10)->nullable();
            $table->string('keg_status', 15)->nullable();
            $table->string('keg_created_by', 50)->nullable();
            $table->dateTime('keg_created_date')->nullable();
            $table->string('keg_modif_by', 50)->nullable();
            $table->dateTime('keg_modif_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bpm_mskegiatan');
    }
};
