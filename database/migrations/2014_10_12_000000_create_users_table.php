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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable()->unique();
            $table->string('alamat')->nullable();
            $table->string('photo')->nullable();
            $table->string('password');
            $table->string('role')->default('dinas');
            $table->unsignedBigInteger('id_wisata')->nullable();
            $table->unsignedBigInteger('id_hotel')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            // foreign key
            // $table->foreign('id_wisata', 'fk_users_wisata')->references('id_wisata')->on('wisata')->onDelete('CASCADE');
            // $table->foreign('id_hotel', 'fk_users_hotel')->references('id_hotel')->on('hotel')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
