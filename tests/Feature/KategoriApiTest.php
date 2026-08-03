<?php

namespace Tests\Feature;

use App\Models\Kategori;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class KategoriApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_get_all_kategori(): void
    {
        Kategori::factory()->count(3)->create();

        $response = $this->getJson("/api/kategori");

        $response->assertStatus(200)->assertJsonStructure([
            "success",
            "message",
            "data" => [
                "*" => ["id", "nama_kategori"],
            ],
        ]);

        $this->assertCount(3, $response->json("data"));
    }

    public function test_can_create_kategori(): void
    {
        $payload = ["nama_kategori" => "Manga Shounen"];

        $response = $this->postJson("/api/kategori", $payload);

        $response->assertStatus(201)->assertJsonFragment([
            "message" => "Kategori berhasil dibuat",
            "nama_kategori" => "Manga Shounen",
        ]);

        $this->assertDatabaseHas("kategoris", [
            "nama_kategori" => "Manga Shounen",
        ]);
    }

    public function test_validation_fails_on_create_kategori(): void
    {
        $response = $this->postJson("/api/kategori", []);

        $response
            ->assertStatus(422)
            ->assertJsonFragment([
                "success" => false,
                "message" => "Validasi data gagal",
            ])
            ->assertJsonStructure([
                "data" => ["nama_kategori"],
            ]);
    }

    public function test_can_show_kategori(): void
    {
        $kategori = Kategori::factory()->create();

        $response = $this->getJson("/api/kategori/{$kategori->id}");

        $response->assertStatus(200)->assertJsonFragment([
            "message" => "Kategori ditemukan",
            "id" => $kategori->id,
        ]);
    }

    public function test_show_kategori_returns_404(): void
    {
        $response = $this->getJson("/api/kategori/999");

        $response
            ->assertStatus(404)
            ->assertJsonFragment(["message" => "Kategori tidak ditemukan"]);
    }

    public function test_can_update_kategori(): void
    {
        $kategori = Kategori::factory()->create();
        $payload = ["nama_kategori" => "Manga Shoujo"];

        $response = $this->putJson("/api/kategori/{$kategori->id}", $payload);

        $response->assertStatus(200)->assertJsonFragment([
            "message" => "Kategori berhasil di update",
            "nama_kategori" => "Manga Shoujo",
        ]);

        $this->assertDatabaseHas("kategoris", [
            "id" => $kategori->id,
            "nama_kategori" => "Manga Shoujo",
        ]);
    }

    public function test_can_delete_kategori(): void
    {
        $kategori = Kategori::factory()->create();

        $response = $this->deleteJson("/api/kategori/{$kategori->id}");

        $response
            ->assertStatus(200)
            ->assertJsonFragment(["message" => "Kategori berhasil dihapus"]);

        $this->assertDatabaseMissing("kategoris", ["id" => $kategori->id]);
    }
}
