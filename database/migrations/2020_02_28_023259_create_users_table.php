<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->smallIncrements('rowid');
            $table->string('name', 50);
            $table->string('email', 40);
            $table->string('login', 20);
            $table->string('password', 128);
            $table->enum('period', ['MANHÃ', 'TARDE']);
            $table->string('remember_token')->nullable();
            $table->unsignedSmallInteger('level_id');
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
        Schema::dropIfExists('users');
    }
}

