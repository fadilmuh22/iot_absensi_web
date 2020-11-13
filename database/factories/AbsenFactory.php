<?php

namespace Database\Factories;

use App\Models\Absen;
use Illuminate\Database\Eloquent\Factories\Factory;

class AbsenFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Absen::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'event_id' => 1,
            'user_id' => $this->faker->numberBetween(1, 5),
            'hadir' =>  $this->faker->numberBetween(0, 1),
            'waktu_hadir' => now(),
        ];
    }
}
