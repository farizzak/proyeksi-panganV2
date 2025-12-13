<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTDistributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_distributions', function (Blueprint $table) {
            $table->integer('year'); 
            $table->integer('bulan'); 
            $table->string('kecamatan'); 
            $table->string('nama')->nullable();
            $table->integer('periode_ke')->nullable(); 
            $table->string('pedagang')->nullable(); 
            $table->string('komoditas'); 
            $table->decimal('pasokan', 10, 2)->default(0); 
            $table->string('satuan_pasokan')->nullable(); 
            $table->decimal('penjualan', 10, 2)->default(0);
            $table->string('satuan_penjualan')->nullable(); 
            $table->decimal('stock', 10, 2)->default(0);
            $table->string('satuan_stock')->nullable();     
            $table->string('harga_currency')->nullable();
            $table->decimal('harga', 10, 2)->nullable(); 
            $table->string('asal')->nullable();
            $table->string('alamat')->nullable(); 
            $table->string('tujuan_pemasaran')->nullable(); 
            $table->string('no_tlp')->nullable();
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
        Schema::dropIfExists('t_distributions');
    }
}
