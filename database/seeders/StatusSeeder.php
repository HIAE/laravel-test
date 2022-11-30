<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert([
            ['number' => 1, 'name' => 'nova'],
            ['number' => 2, 'name' => 'em análise'],
            ['number' => 3, 'name' => 'em progresso'],
            ['number' => 4, 'name' => 'implementada'],
            ['number' => 5, 'name' => 'fechada'],
        ]);
    }
}
