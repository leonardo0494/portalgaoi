<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsStartAndEndDateToPlantaoEquipe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plantao_equipe', function (Blueprint $table) {
            $table->dateTime('start_date')->after('id');
            $table->dateTime('end_date')->after('start_date');
            $table->dropColumn('dia_plantao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plantao_equipe', function (Blueprint $table) {
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dateTime('dia_plantao');
        });
    }
}
