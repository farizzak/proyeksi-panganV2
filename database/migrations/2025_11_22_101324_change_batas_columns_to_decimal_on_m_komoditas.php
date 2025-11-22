<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeBatasColumnsToDecimalOnMKomoditas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_komoditas', function (Blueprint $table) {
            $table->decimal('batas_aman', 5, 2)->nullable()->change();
            $table->decimal('batas_waspada', 5, 2)->nullable()->change();
            $table->decimal('batas_intervensi', 5, 2)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('m_komoditas', function (Blueprint $table) {
            $table->integer('batas_aman')->nullable()->change();
            $table->integer('batas_waspada')->nullable()->change();
            $table->integer('batas_intervensi')->nullable()->change();
        });
    }

}
