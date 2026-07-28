<?php

namespace Tests\Feature;

use App\Models\Anggota;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AnggotaApiTest extends TestCase
{
    use RefreshDatabase; // Reset database setelah setiap test
    use WithFaker; // Untuk generate data fake jika diperlukan

    /**
     * Test mendapatkan daftar semua anggota.
     */
    public function test_can_get_all_anggota(): void
    {
        // Persiapan: Buat 5 data anggota dummy
        Anggota::factory()->count(5)->create();

        // Aksi: Request GET ke endpoint index
        $response = $this->getJson('/api/anggota');

        // Assert: Cek status HTTP dan struktur JSON
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'message',
                     'data' => [
                         '*' => [
                             'id',
                             'nama',
                             'no_hp',
                             'alamat',
                             'tanggal_daftar',
                             'created_at',
                             'updated_at'
                         ]
                     ]
                 ]);
        
        // Assert: Pastikan ada 5 data yang dikembalikan
        $this->assertCount(5, $response->json('data'));
    }

    /**
     * Test membuat data anggota baru (berhasil).
     */
    public function test_can_create_anggota(): void
    {
        // Persiapan payload
        $payload = [
            "nama" => "Ridaz Riyandi",
            "no_hp" => "081234567890",
            "alamat" => "Jl. Sudirman No. 1",
            "tanggal_daftar" => "2026-07-21",
        ];

        // Aksi: Request POST ke endpoint store
        $response = $this->postJson("/api/anggota", $payload);

        // Assert: Cek status HTTP dan pesan
        $response->assertStatus(201)->assertJsonFragment([
            "message" => "Berhasil membuat data anggota",
            "nama" => "Ridaz Riyandi",
        ]);

        // Assert: Cek apakah data benar-benar tersimpan di database
        $this->assertDatabaseHas("anggotas", [
            "nama" => "Ridaz Riyandi",
            "no_hp" => "081234567890",
        ]);
    }

    /**
     * Test validasi saat membuat data anggota (gagal karena kosong).
     */
    public function test_validation_fails_on_create_anggota(): void
    {
        // Request POST dengan payload kosong
        $response = $this->postJson("/api/anggota", []);

        // Assert status 422 (Unprocessable Entity) karena validasi gagal
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                "nama",
                "no_hp",
                "alamat",
                "tanggal_daftar",
            ]);
    }

    /**
     * Test melihat detail spesifik satu anggota.
     */
    public function test_can_show_anggota(): void
    {
        // Persiapan: Buat 1 data anggota dummy
        $anggota = Anggota::factory()->create();

        // Aksi: Request GET ke endpoint show dengan ID anggota tersebut
        $response = $this->getJson("/api/anggota/{$anggota->id}");

        // Assert: Status OK dan data cocok
        $response->assertStatus(200)->assertJsonFragment([
            "message" => "Berhasil mengambil data anggota",
            "id" => $anggota->id,
            "nama" => $anggota->nama,
        ]);
    }

    /**
     * Test melihat detail anggota yang tidak ada (Error 404).
     */
    public function test_show_returns_404_if_not_found(): void
    {
        // Aksi: Request GET ke ID yang dipastikan tidak ada
        $response = $this->getJson("/api/anggota/999");

        // Assert: Status 404 Not Found
        $response->assertStatus(404)->assertJsonFragment([
            "message" => "Anggota tidak ditemukan",
            "data" => null,
        ]);
    }

    /**
     * Test mengupdate data anggota.
     */
    public function test_can_update_anggota(): void
    {
        // Persiapan: Buat 1 data anggota dummy
        $anggota = Anggota::factory()->create();

        // Payload data baru (hanya update nama dan nomor HP)
        $payload = [
            "nama" => "Nama Terupdate",
            "no_hp" => "08999999999",
        ];

        // Aksi: Request PUT ke endpoint update
        $response = $this->putJson("/api/anggota/{$anggota->id}", $payload);

        // Assert: Status OK dan respons JSON sesuai
        $response->assertStatus(200)->assertJsonFragment([
            "message" => "Data anggota berhasil diupdate",
            "nama" => "Nama Terupdate",
        ]);

        // Assert: Pastikan data di database juga berubah
        $this->assertDatabaseHas("anggotas", [
            "id" => $anggota->id,
            "nama" => "Nama Terupdate",
            "no_hp" => "08999999999",
        ]);
    }

    /**
     * Test menghapus data anggota.
     */
    public function test_can_delete_anggota(): void
    {
        // Persiapan: Buat 1 data anggota dummy
        $anggota = Anggota::factory()->create();

        // Aksi: Request DELETE ke endpoint destroy
        $response = $this->deleteJson("/api/anggota/{$anggota->id}");

        // Assert: Status OK dan respons sesuai
        $response->assertStatus(200)->assertJsonFragment([
            "message" => "Anggota berhasil dihapus",
            "success" => true,
        ]);

        // Assert: Pastikan data sudah hilang dari database
        $this->assertDatabaseMissing("anggotas", [
            "id" => $anggota->id,
        ]);
    }
}
