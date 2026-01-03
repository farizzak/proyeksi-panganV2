<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropcolumnPeriodeKeToTDistributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_distributions', function (Blueprint $table) {
            $table->dropColumn('periode_ke');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_distributions', function (Blueprint $table) {
            $table->integer('periode_ke')->nullable();
        });
    }
}
