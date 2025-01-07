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
        Schema::create('bpm_msJenisKegiatan', function (Blueprint $table) {
            $table->id('jkg_id');
            $table->string('jkg_nama', 100)->nullable();
            $table->string('jkg_status', 15)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bpm_msJenisKegiatan');
    }
};
