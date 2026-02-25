<?php

namespace Database\Seeders;

use App\Models\Rank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Rank::updateOrCreate(['name' => '1급'], ['level' => 1]);
        Rank::updateOrCreate(['name' => '1급'], ['level' => 1]);
        Rank::updateOrCreate(['name' => '2급'], ['level' => 2]);
        Rank::updateOrCreate(['name' => '관리자급'], ['level' => 99]);
    }
}
