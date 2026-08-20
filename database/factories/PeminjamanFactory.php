<?php

namespace Database\Factories;

use App\Models\Anggota;
use App\Models\Komik;
use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Peminjaman>
 */
class PeminjamanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tanggalPeminjaman = $this->faker->dateTimeBetween("-1 month", "now");
        // Membuat copy objek DateTime lalu menambahkan 7 hari untuk tanggal pengembalian
        $tanggalPengembalian = (clone $tanggalPeminjaman)->modify("+7 days");

        return [
            "anggota_id" =>
                Anggota::inRandomOrder()->first()->id ?? Anggota::factory(),
            "komik_id" =>
                Komik::inRandomOrder()->first()->id ?? Komik::factory(),
            "tanggal_peminjaman" => $tanggalPeminjaman->format("Y-m-d"),
            "tanggal_pengembalian" => $tanggalPengembalian->format("Y-m-d"),
            "status" => $this->faker->randomElement([
                "dipinjam",
                "dikembalikan",
                "telat",
            ]),
        ];
    }
}
