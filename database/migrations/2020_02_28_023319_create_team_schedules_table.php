<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_schedules', function (Blueprint $table) {
            $table->smallIncrements('rowid');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('ttype', ['PLANTÃO', 'FÉRIAS', 'FOLGA']);
            $table->unsignedSmallInteger('user_id');
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
        Schema::dropIfExists('team_schedules');
    }
}
