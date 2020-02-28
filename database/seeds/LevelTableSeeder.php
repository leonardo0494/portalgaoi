<?php

use Illuminate\Database\Seeder;

class LevelTableSeeder extends Seeder
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
    }
}
