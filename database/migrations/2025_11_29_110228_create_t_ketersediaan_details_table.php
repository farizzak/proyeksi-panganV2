<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTKetersediaanDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_ketersediaan_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ketersediaan_id');
            $table->unsignedBigInteger('komoditas_id');

            $table->string('nama_komoditas');
            $table->string('satuan')->nullable();
            $table->date('tanggal');

            // Harga
            $table->double('harga_sebelumnya')->default(0);
            $table->double('harga_hari_ini')->default(0);
            $table->string('keterangan_harga')->nullable(); // naik / turun / tetap

            // Stok
            $table->double('stok_awal')->default(0);
            $table->double('stok_distributor')->default(0);
            $table->double('stok_pasar')->default(0);
            $table->double('stok_produksi')->default(0);
            $table->double('stok_bulog')->default(0);

            $table->double('jumlah_stok_total')->default(0);

            // Kebutuhan
            $table->double('kebutuhan_rt')->default(0);
            $table->double('kebutuhan_nonrt')->default(0);
            $table->double('total_kebutuhan')->default(0);

            // Neraca
            $table->double('neraca')->default(0);
            $table->string('kecukupan_harian')->nullable();

            // Asal pasokan (1 kolom text)
            $table->text('asal_pasokan')->nullable();

            $table->softDeletes();
            $table->timestamps();

            // Foreign Key
            $table->foreign('ketersediaan_id')
                ->references('id')->on('t_ketersediaans')
                ->onDelete('cascade');

            $table->foreign('komoditas_id')
                ->references('id')->on('m_komoditas')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_ketersediaan_details');
    }
}
