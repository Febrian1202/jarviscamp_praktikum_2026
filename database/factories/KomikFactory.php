<?php

namespace Database\Factories;

use App\Models\Kategori;
use App\Models\Komik;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Komik>
 */
class KomikFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            "judul" => fake()->sentence(3),
            "penulis" => fake()->name(),
            "kategori_id" =>
                Kategori::inRandomOrder()->first()?->id ?? Kategori::factory(),
            "stok" => fake()->numberBetween(0, 20),
            "status" => fake()->randomElement(["available", "unavailable"]),
            "file_pdf" => fake()->optional(0.5)->passthrough(fake()->word() . '.pdf'),
        ];
    }
}
