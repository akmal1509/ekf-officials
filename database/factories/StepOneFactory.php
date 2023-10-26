<?php

namespace Database\Factories;

use App\Models\Schools;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StepOne>
 */
class StepOneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $idKecamatan = '2224';
        $ciamis = \Indonesia::findCity('167', ['villages'])->villages->pluck('id')->toArray();
        $dataSelect = \Indonesia::findDistrict($idKecamatan, ['villages'])->villages->pluck('id')->toArray();
        return [
            'userId' => '80',
            'villageId' => $this->faker->randomElement($ciamis),
            'schoolId' => Schools::all()->random()->id,
            'headmaster' => $this->faker->name(),
            'phoneHeadmaster' => '0808',
            'schoolOperator' => $this->faker->name(),
            'phoneOperator' => '0101',
            'chairman' => $this->faker->name(),
            'phoneChairman' => '1212',
            'image' => 'https://source.unsplash.com/random'
        ];
    }
}
