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

    public function setUp(): void
    {
        parent::setUp();
        // Setup autentikasi karena route membutuhkan auth:sanctum
        \App\Models\User::factory()->create();
        $this->actingAs(\App\Models\User::first());
    }

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
        $response->assertStatus(200);
        
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
        $response->assertStatus(201);

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
            ->assertJsonStructure([
                "message"
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
        $response->assertStatus(200);
    }

    /**
     * Test melihat detail anggota yang tidak ada (Error 404).
     */
    public function test_show_returns_404_if_not_found(): void
    {
        $response = $this->getJson("/api/anggota/99999");
        $response->assertStatus(404);
    }

    /**
     * Test mengupdate data anggota.
     */
    public function test_can_update_anggota(): void
    {
        // Persiapan: Buat 1 data anggota dummy
        $anggota = Anggota::factory()->create();
        $id = $anggota->id;

        // Payload data baru (hanya update nama dan nomor HP)
        $payload = [
            "nama" => "Nama Terupdate",
            "no_hp" => "081234567890", // Sesuai regex
            "alamat" => "Jl. Terupdate",
            "tanggal_daftar" => "2026-07-21"
        ];

        // Aksi: Request PUT ke endpoint update
        $response = $this->putJson("/api/anggota/{$id}", $payload);
        
        $response->assertStatus(200);

        // Pastikan model refresh dari database
        $anggota->refresh();
        $this->assertEquals("Nama Terupdate", $anggota->nama);
        $this->assertEquals("081234567890", $anggota->no_hp);

        // Assert: Pastikan data di database juga berubah
        $this->assertDatabaseHas("anggotas", [
            "id" => $id,
            "nama" => "Nama Terupdate",
            "no_hp" => "081234567890",
        ]);
    }

    /**
     * Test menghapus data anggota.
     */
    public function test_can_delete_anggota(): void
    {
        // Persiapan: Buat 1 data anggota dummy
        $anggota = Anggota::factory()->create();
        $id = $anggota->id;

        // Aksi: Request DELETE ke endpoint destroy
        $response = $this->deleteJson("/api/anggota/{$id}");
        $response->assertStatus(200);
        
        $this->assertDatabaseMissing('anggotas', ['id' => $id]);
        $this->assertDatabaseCount('anggotas', 0);
    }
}
