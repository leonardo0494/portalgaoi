<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTelefoneLoginOiLoginRemedyToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('login_remedy')->nullable()->after('profile_image');
            $table->string('login_oi')->nullable()->after('profile_image');
            $table->string('personal_phone')->nullable()->after('profile_image');
            $table->string('work_phone')->nullable()->after('profile_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            
            $table->dropColumn('work_phone');
            $table->dropColumn('personal_phone');
            $table->dropColumn('login_oi');
            $table->dropColumn('login_remedy');
        });
    }
}
