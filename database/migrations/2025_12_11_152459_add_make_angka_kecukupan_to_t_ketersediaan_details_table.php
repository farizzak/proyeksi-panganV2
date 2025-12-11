<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMakeAngkaKecukupanToTKetersediaanDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_ketersediaan_details', function (Blueprint $table) {
            $table->double('angka_kecukupan')->default(0)->after('neraca');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_ketersediaan_details', function (Blueprint $table) {
            $table->dropColumn('angka_kecukupan');
        });
    }
}
