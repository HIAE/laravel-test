<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('users')->insert([
            'name' => 'Rafael Lotto',
            'email' => 'rafael@test.com',
            'cpf' => '000.000.000-00',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);
    }
}
