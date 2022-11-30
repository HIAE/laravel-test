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
            ['name' => 'nova'],
            ['name' => 'em análise'],
            ['name' => 'em progresso'],
            ['name' => 'implementada'],
            ['name' => 'fechada'],
        ]);
    }
}
