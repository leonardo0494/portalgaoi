<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateARSSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arss', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ars', 16);
            $table->enum('categorie', ['MIGRACAO', 'MANUTENCAO', 'SUPORTE A TESTE']);
            $table->enum('pendencia', ['SIM', 'NAO']);
            $table->unsignedBigInteger('reports_id');
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
        Schema::dropIfExists('arss');
    }
}
