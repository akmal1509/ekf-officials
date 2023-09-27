<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonFile = database_path('seeders/data/school.json');

        // Baca isi file JSON
        $data = json_decode(file_get_contents($jsonFile), true);

        // Simpan data ke dalam tabel 'users'
        foreach ($data as $item) {
            \DB::table('schools')->insert([
                'name' => $item['name'],
                'villageId' => $item['vilId'],
                'levelId' => '1'
            ]);
        }
    }
}
