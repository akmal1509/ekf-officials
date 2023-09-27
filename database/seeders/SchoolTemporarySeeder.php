<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolTemporarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jsonFile = database_path('seeders/data/schoolTemporary.json');

        // Baca isi file JSON
        $data = json_decode(file_get_contents($jsonFile), true);

        // Simpan data ke dalam tabel 'users'
        foreach ($data as $item) {
            \DB::table('school_temporaries')->insert([
                'name' => $item['name'],
                'village' => $item['village'],
            ]);
        }
    }
}
