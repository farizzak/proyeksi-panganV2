<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameNameToDistributorInTDistributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_distributions', function (Blueprint $table) {
            $table->renameColumn('nama', 'distributor');
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
            $table->renameColumn('distributor', 'nama');
        });
    }
}
