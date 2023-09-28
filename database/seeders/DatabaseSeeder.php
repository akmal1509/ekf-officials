<?php

namespace Database\Seeders;

use App\Models\StepOne;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Laravolt\Indonesia\Seeds\DatabaseSeeder as Laravolt;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            Laravolt::class,
        ]);
        $this->call([
            UsersTableSeeder::class,
            DapilCategoriesTableSeeder::class,
            DapilDistrictsTableSeeder::class,
            DapilDistrictGosTableSeeder::class,
            AssignmentsTableSeeder::class,
            EducationLevelSeeder::class,
            SchoolSeeder::class
        ]);
        // $this->call(UsersTableSeeder::class);
        // $this->call(AssignmentsTableSeeder::class);
    }
}
