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
        DB::table('users')->insert([
            [
               'name' => 'Leandro Valcace Gonçalves',
               'email' => 'leandro.valcace@trescon.com.br',
               'login' => 'leandro.valcace',
               'password' => hash::make('123456'),
               'period' => 'MANHÃ',
               'level_id' => 1
            ],
            [
                'name' => 'Leonardo de Lima Silva',
                'email' => 'leonardo.lima@trescon.com.br',
                'login' => 'leonardo.lima',
                'password' => hash::make('123456'),
                'period' => 'TARDE',
                'level_id' => 2
             ],
        ]);
    }
}
