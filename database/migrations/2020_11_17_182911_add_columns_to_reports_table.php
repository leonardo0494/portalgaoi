<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dateTime('inicio_atendimento_editado')->after('final_atendimento')->nullable();
            $table->dateTime('final_atendimento_editado')->after('inicio_atendimento_editado')->nullable();
            $table->char('editado', 1)->after('final_atendimento_editado')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn('inicio_atendimento_editado');
            $table->dropColumn('final_atendimento_editado');
            $table->dropColumn('editado');
        });
    }
}
