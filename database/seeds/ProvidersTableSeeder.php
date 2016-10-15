<?php

use Illuminate\Database\Seeder;

class ProvidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('providers')->insert([
            ['provider' => 'facebook'],
            ['provider' => 'instagram'],
            ['provider' => 'pocket'],
            ['provider' => 'pinterest']
        ]);
    }
}
