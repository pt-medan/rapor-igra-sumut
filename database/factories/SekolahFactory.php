<?php

namespace Database\Factories;

use App\Models\Sekolah;
use Illuminate\Database\Eloquent\Factories\Factory;

class SekolahFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sekolah::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_sekolah' => $this->faker->name(),
            'npsn' => $this->faker->unique()->randomNumber(8),
            'alamat' => $this->faker->address(),
            'provinsi' => $this->faker->state(),
            'kabupaten' => $this->faker->city(),
            'kepala_sekolah' => $this->faker->name(),
            'status' => $this->faker->randomElement(['negeri', 'swasta']),
        ];
    }
}
