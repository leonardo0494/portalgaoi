<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('tipo', ['DEFEITO', 'CALL', 'ARS', 'MELHORIAS', 'MONITORAMENTO', 'TREINAMENTO', 'RELATORIOS', 'REUNIÃO']);
            $table->string('prj_ent', 24)->nullable();
            $table->string('ars', 16)->nullable();
            $table->string('def', 5)->nullable();
            $table->enum('pendencia', ['SIM', 'NAO']);
            $table->string('sistema', 20)->nullable();
            $table->string('descricao', 180);
            $table->dateTime('inicio_atendimento');
            $table->dateTime('final_atendimento');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
