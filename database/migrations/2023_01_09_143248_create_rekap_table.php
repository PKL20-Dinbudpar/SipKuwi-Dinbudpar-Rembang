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
        Schema::create('rekap', function (Blueprint $table) {
            $table->id('id_rekap');
            $table->date('tanggal');
            $table->unsignedBigInteger('id_wisata');
            $table->integer('wisatawan_domestik')->default(0);
            $table->integer('wisatawan_mancanegara')->default(0);
            $table->integer('total_pendapatan')->default(0);

            $table->foreign('id_wisata', 'fk_rekap_wisata')->references('id_wisata')->on('wisata');

            $table->unique(['tanggal', 'id_wisata']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap');
    }
};
