<?php

namespace Database\Seeders;

use App\Models\EducationLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EducationLevel::create([
            'name' => 'SD'
        ]);
        EducationLevel::create([
            'name' => 'SMP'
        ]);
        EducationLevel::create([
            'name' => 'SMA'
        ]);
    }
}
