<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// use DB


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekap_wisata', function (Blueprint $table) {
            $table->id('id_rekap');
            $table->date('tanggal');
            $table->unsignedBigInteger('id_wisata')->nullable();
            $table->integer('wisatawan_nusantara')->default(0);
            $table->integer('wisatawan_mancanegara')->default(0);
            $table->bigInteger('total_pendapatan')->default(0);
            $table->unsignedBigInteger('id_user')->nullable()->default(2);
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('id_wisata', 'fk_rekap_wisata')->references('id_wisata')->on('wisata')->onDelete('cascade');
            $table->foreign('id_user', 'fk_rekap_wisata_user')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('rekap_wisata');
    }
};
