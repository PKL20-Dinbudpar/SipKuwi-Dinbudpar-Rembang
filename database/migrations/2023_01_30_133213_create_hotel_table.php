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
        Schema::create('hotel', function (Blueprint $table) {
            $table->id('id_hotel');
            $table->string('nama_hotel');
            $table->string('alamat')->nullable();
            $table->char('id_kecamatan', 3)->nullable();

            $table->foreign('id_kecamatan', 'fk_hotel_kecamatan')->references('id_kecamatan')->on('kecamatan')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotel');
    }
};
