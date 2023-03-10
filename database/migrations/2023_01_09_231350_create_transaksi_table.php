<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->dateTime('waktu_transaksi')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedBigInteger('id_wisata');
            $table->unsignedBigInteger('id_user');
            $table->string('jenis_wisatawan');
            $table->integer('jumlah_tiket')->default(0);
            $table->integer('uang_masuk')->default(0);
            $table->integer('kembalian')->default(0);
            $table->integer('total_pendapatan');

            $table->foreign('id_wisata', 'fk_transaksi_wisata')->references('id_wisata')->on('wisata')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
};
