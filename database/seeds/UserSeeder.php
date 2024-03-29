<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nrp' => 'admin',
            'name' => 'Admin',
            'password' => Hash::make('admin123456')
        ]);
    }
}
