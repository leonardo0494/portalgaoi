<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

	DB::table('levels')->insert([
            ['name' => 'ADMINISTRADOR'],
            ['name' => 'TÉCNICO']
        ]);

        DB::table('users')->insert([
            [
               'name' => 'LEANDRO VALCACE GONCALVES',
               'email' => 'leandro.goncalves@trescon.com.br',
               'login' => 'leandro.goncalves',
               'password' => hash::make('123456'),
               'period' => 'MANHÃ',
               'level_id' => 1
            ],
            [
                'name' => 'LEONARDO DE LIMA SILVA',
                'email' => 'leonardo.lima@trescon.com.br',
                'login' => 'leonardo.lima',
                'password' => hash::make('123456'),
                'period' => 'TARDE',
                'level_id' => 2
            ],
            [
                'name' => 'ALDERICO QUEIROZ PEREIRA JUNIOR',
                'email' => 'alderico.junior@trescon.com.br',
                'login' => 'alderico.junior',
                'password' => hash::make('123456'),
                'period' => 'MANHÃ',
                'level_id' => 2
            ],
            [
                'name' => 'CARMEN APARECIDA LARA',
                'email' => 'carmen.lara@trescon.com.br',
                'login' => 'carmen.lara',
                'password' => hash::make('123456'),
                'period' => 'TARDE',
                'level_id' => 2
            ],
            [
                'name' => 'DANIELLA TAROUQUELLA MONASSA FLORES DE AGUIAR',
                'email' => 'daniella.monassa@trescon.com.br',
                'login' => 'daniella.monassa',
                'password' => hash::make('123456'),
                'period' => 'MANHÃ',
                'level_id' => 2
            ],
            [
               'name' => 'DIEGO SOUSA VIEIRA',
               'email' => 'diego.vieira@trescon.com.br',
               'login' => 'diego.vieira',
               'password' => hash::make('123456'),
               'period' => 'MANHÃ',
               'level_id' => 2
            ],
            [
               'name' => 'GEOVANE DA SILVA JORGE',
               'email' => 'geovane.jorge@trescon.com.br',
               'login' => 'geovane.jorge',
               'password' => hash::make('123456'),
               'period' => 'TARDE',
               'level_id' => 2
            ],
            [
               'name' => 'JULIO CESAR GOMES FERNANDES',
               'email' => 'julio.fernandes@trescon.com.br',
               'login' => 'julio.fernandes',
               'password' => hash::make('123456'),
               'period' => 'TARDE',
               'level_id' => 2
            ],
            [
               'name' => 'LEANDRO DE SOUZA ALBUQUERQUE',
               'email' => 'leandro.albuquerque@trescon.com.br',
               'login' => 'leandro.albuquerque',
               'password' => hash::make('123456'),
               'period' => 'MANHÃ',
               'level_id' => 2
            ],
            [
               'name' => 'LUANA PAES DE OLIVEIRA TOLEDO DE QUEIROS',
               'email' => 'luana.queiros@trescon.com.br',
               'login' => 'luana.queiros',
               'password' => hash::make('123456'),
               'period' => 'MANHÃ',
               'level_id' => 2
            ],
            [
               'name' => 'MARCIO ANDRE CASTELO BRANCO ZAMPIRON',
               'email' => 'marcio.zampiron@trescon.com.br',
               'login' => 'marcio.zampiron',
               'password' => hash::make('123456'),
               'period' => 'TARDE',
               'level_id' => 2
            ],
            [
               'name' => 'NEILSON DA COSTA FARIA',
               'email' => 'neilson.faria@trescon.com.br',
               'login' => 'neilson.faria',
               'password' => hash::make('123456'),
               'period' => 'MANHÃ',
               'level_id' => 2
            ],
            [
               'name' => 'STEFANO GROSSI MIRANDA',
               'email' => 'stefano.miranda@trescon.com.br',
               'login' => 'stefano.miranda',
               'password' => hash::make('123456'),
               'period' => 'MANHÃ',
               'level_id' => 2
            ],
            [
               'name' => 'THARIANY ANDRADE DE CARVALHO',
               'email' => 'thariany.carvalho@trescon.com.br',
               'login' => 'thariany.carvalho',
               'password' => hash::make('123456'),
               'period' => 'MANHÃ',
               'level_id' => 2
            ],
            [
               'name' => 'THIAGO BRAGA NORBRE',
               'email' => 'thiago.nobre@trescon.com.br',
               'login' => 'thiago.nobre',
               'password' => hash::make('123456'),
               'period' => 'MANHÃ',
               'level_id' => 2
            ],
            [
               'name' => 'WELLINGTON DE ALCANTARA',
               'email' => 'wellington.alcantara@trescon.com.br',
               'login' => 'wellington.alcantara',
               'password' => hash::make('123456'),
               'period' => 'TARDE',
               'level_id' => 2
            ],
            [
               'name' => 'WILLIAM SANTANA SANTOS',
               'email' => 'william.santana@trescon.com.br',
               'login' => 'william.santana',
               'password' => hash::make('123456'),
               'period' => 'MANHÃ',
               'level_id' => 2
            ]
        ]);
    }
}
