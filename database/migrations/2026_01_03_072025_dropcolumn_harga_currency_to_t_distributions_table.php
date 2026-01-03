<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropcolumnHargaCurrencyToTDistributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_distributions', function (Blueprint $table) {
            $table->dropColumn('harga_currency');
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
            $table->string('harga_currency')->nullable();
        });
    }
}
