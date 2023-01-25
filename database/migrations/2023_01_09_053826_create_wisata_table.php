<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wisata', function (Blueprint $table) {
            $table->id('id_wisata');
            $table->string('nama_wisata');
            $table->string('alamat')->nullable();
            $table->char('id_kecamatan', 3)->nullable();

            $table->foreign('id_kecamatan', 'fk_wisata_kecamatan')->references('id_kecamatan')->on('kecamatan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wisata');
    }
};
