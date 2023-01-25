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
        Schema::create('tiket', function (Blueprint $table) {
            $table->id('id_tiket');
            $table->unsignedBigInteger('id_wisata');
            $table->string('nama_tiket');
            $table->integer('harga');
            $table->string('deskripsi')->nullable();

            $table->foreign('id_wisata', 'fk_tiket_wisata')->references('id_wisata')->on('wisata')->onDelete('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tiket');
    }
};
