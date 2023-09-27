<?php

namespace Database\Seeders;

use App\Models\StepOne;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StepOneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StepOne::truncate();
        StepOne::factory(100)->create();
        // for ($i = 0; $i < 100; $i++) {
        //     StepOne::create([
        //         'userId' => '80',
        //         'villageId' => '28071',
        //         'schoolId' => '117',
        //         'kepalaSekolah' => 'Kelapa',
        //         'telKepala' => '0808',
        //         'operatorSekolah' => 'opera',
        //         'telOperator' => '0101',
        //         'ketuaKomite' => 'komit',
        //         'telKomite' => '1212',
        //         'image' => 'logorkf-1694972082.png'
        //     ]);
        // }
    }
}
