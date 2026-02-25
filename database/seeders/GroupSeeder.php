<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Group::updateOrCreate(['name' => '1팀']);
        Group::updateOrCreate(['name' => '2팀']);
        Group::updateOrCreate(['name' => '3팀']);
    }
}
