<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsActivityOnlineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activity_onlines', function (Blueprint $table) {
            $table->enum("call", ["Sim", "Não"])->after('user_id');
            $table->string("motivo")->after('call')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activity_onlines', function (Blueprint $table) {
            $table->dropColumn("call");
            $table->dropColumn("motivo");
        });
    }
}
