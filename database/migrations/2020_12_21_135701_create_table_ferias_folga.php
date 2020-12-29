<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFeriasFolga extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ferias_folga', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->ENUM('tipo', ['FÉRIAS', 'FOLGA']);
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
        Schema::dropIfExists('ferias_folga');
    }
}
