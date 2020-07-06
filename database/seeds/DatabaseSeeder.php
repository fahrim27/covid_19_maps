<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(WilayahSeeder::class);
        $this->call(JenisKasusSeeder::class);
        $this->call(UserSeeder::class);
    }
}
