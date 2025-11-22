<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMKomoditasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_komoditas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kategori_id')->nullable();
            $table->string('name');
            $table->string('satuan')->nullable();
            $table->boolean('status')->nullable()->default(false);
            $table->string('tipe_acuan')->nullable();
            $table->integer('batas_aman')->nullable();
            $table->integer('batas_waspada')->nullable();
            $table->integer('batas_intervensi')->nullable();
            $table->string('url_gambar')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_komoditas');
    }
}
