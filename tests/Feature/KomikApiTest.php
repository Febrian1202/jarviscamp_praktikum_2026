<?php

namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\Komik;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class KomikApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_get_all_komik(): void
    {
        // Komik membutuhkan Kategori, jadi kita buat dulu
        $kategori = Kategori::factory()->create();
        Komik::factory()
            ->count(3)
            ->create(["kategori_id" => $kategori->id]);

        $response = $this->getJson("/api/komik");

        $response->assertStatus(200)->assertJsonStructure([
            "success",
            "message",
            "data" => [
                "*" => [
                    "id",
                    "judul",
                    "penulis",
                    "kategori_id",
                    "stok",
                    "status",
                    "file_pdf",
                ],
            ],
        ]);

        $this->assertCount(3, $response->json("data"));
    }

    public function test_can_create_komik(): void
    {
        $kategori = Kategori::factory()->create();

        $payload = [
            "judul" => "One Piece Vol 1",
            "kategori_id" => $kategori->id,
            "stok" => 10,
            "penulis" => "Eiichiro Oda",
            "tanggal_terbit" => "1997-07-22", // Sesuai field validasi di store
        ];

        $response = $this->postJson("/api/komik", $payload);

        $response->assertStatus(201)->assertJsonFragment([
            "message" => "Sukses membuat data komik",
            "judul" => "One Piece Vol 1",
        ]);

        $this->assertDatabaseHas("komiks", [
            "judul" => "One Piece Vol 1",
            "penulis" => "Eiichiro Oda",
        ]);
    }

    public function test_validation_fails_on_create_komik(): void
    {
        $response = $this->postJson("/api/komik", []);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                "judul",
                "kategori_id",
                "stok",
                "penulis",
                "tanggal_terbit",
            ]);
    }

    public function test_can_show_komik(): void
    {
        $kategori = Kategori::factory()->create();
        $komik = Komik::factory()->create(["kategori_id" => $kategori->id]);

        $response = $this->getJson("/api/komik/{$komik->id}");

        $response->assertStatus(200)->assertJsonFragment([
            "message" => "Komik ditemukan",
            "id" => $komik->id,
        ]);
    }

    public function test_show_komik_returns_404(): void
    {
        $response = $this->getJson("/api/komik/999");

        $response
            ->assertStatus(404)
            ->assertJsonFragment([
                "message" => "Komik tidak ditemukan",
                "success" => false,
                "data" => null,
            ]);
    }

    public function test_can_update_komik(): void
    {
        $kategori = Kategori::factory()->create();
        $komik = Komik::factory()->create(["kategori_id" => $kategori->id]);

        $payload = [
            "judul" => "Judul Komik Terupdate",
            "stok" => 50,
        ];

        $response = $this->putJson("/api/komik/{$komik->id}", $payload);

        $response->assertStatus(200)->assertJsonFragment([
            "message" => "Data komik berhasil diupdate",
            "judul" => "Judul Komik Terupdate",
        ]);

        $this->assertDatabaseHas("komiks", [
            "id" => $komik->id,
            "judul" => "Judul Komik Terupdate",
            "stok" => 50,
        ]);
    }

    public function test_can_delete_komik(): void
    {
        $kategori = Kategori::factory()->create();
        $komik = Komik::factory()->create(["kategori_id" => $kategori->id]);

        $response = $this->deleteJson("/api/komik/{$komik->id}");

        $response->assertStatus(200)->assertJsonFragment([
            "message" => "Data komik berhasil dihapus",
            "success" => true,
        ]);

        $this->assertDatabaseMissing("komiks", ["id" => $komik->id]);
    }
}
