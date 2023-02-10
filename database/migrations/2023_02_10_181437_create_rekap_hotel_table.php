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
        Schema::create('rekap_hotel', function (Blueprint $table) {
            $table->id('id_rekap');
            $table->date('tanggal');
            $table->unsignedBigInteger('id_hotel')->nullable();
            $table->integer('pengunjung_nusantara')->default(0);
            $table->integer('pengunjung_mancanegara')->default(0);
            $table->integer('kamar_terjual')->nullable();

            $table->foreign('id_hotel', 'fk_rekap_hotel')->references('id_hotel')->on('hotel')->onDelete('cascade');

            $table->unique(['tanggal', 'id_hotel']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_hotel');
    }
};
