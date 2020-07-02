<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategorieToDefeitosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('defeitos', function (Blueprint $table) {
            $table->enum('categorie', ['ERRO DE MIGRACAO', 'INDISPONIBILIDADE', 'PARAMETRIZACAO', 'CODIGO', 'INFRAESTRUTURA'])->after('def')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('defeitos', function (Blueprint $table) {
            $table->dropColumn('categorie');
        });
    }
}
