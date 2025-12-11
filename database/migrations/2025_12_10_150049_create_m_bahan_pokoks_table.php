<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMBahanPokoksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_bahan_pokoks', function (Blueprint $table) {
            $table->id();
            $table->string('bahan_pokok');
            $table->string('satuan');
            $table->decimal('harga_tanggal_1', 8, 2);
            $table->decimal('harga_tanggal_2', 8, 2);
            $table->decimal('persentase', 5, 2);
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('m_bahan_pokoks');
    }
}
