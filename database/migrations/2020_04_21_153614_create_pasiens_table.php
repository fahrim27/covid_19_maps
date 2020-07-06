<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasiens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('petugas_id');
            $table->foreign('petugas_id')->references('id')->on('users');
            $table->string('nik');
            $table->string('nama');
            $table->string('alamat_ktp');
            $table->string('alamat_sekarang');
            $table->integer('usia');
            $table->string('jenis_kelamin');
            $table->unsignedBigInteger('jenis_kasus_id');
            $table->foreign('jenis_kasus_id')->references('id')->on('jenis_kasuses');
            $table->tinyInteger('jenis_isolasi')->default(0);//0 = mandiri, 1 = rs
            $table->double('lat', 11, 8);
            $table->double('lng', 11, 8);
            $table->unsignedBigInteger('kelurahan_id')->nullable();
            $table->foreign('kelurahan_id')->references('id')->on('kelurahans');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pasiens');
    }
}
