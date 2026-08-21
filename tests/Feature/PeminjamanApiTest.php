<?php

namespace Tests\Feature;

use App\Models\Anggota;
use App\Models\Komik;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PeminjamanApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        // Setup autentikasi karena route membutuhkan auth:sanctum
        User::factory()->create();
        $this->actingAs(User::first());
    }

    public function test_can_get_all_peminjaman(): void
    {
        Peminjaman::factory()->count(3)->create();

        $response = $this->getJson('/api/peminjaman');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'message',
                     'data' => [
                         '*' => [
                             'id',
                             'anggota_id',
                             'komik_id',
                             'nama_anggota',
                             'judul_komik',
                             'status',
                         ]
                     ]
                 ]);

        $this->assertCount(3, $response->json('data'));
    }

    public function test_can_create_peminjaman(): void
    {
        $anggota = Anggota::factory()->create();
        $komik = Komik::factory()->create(['stok' => 5]);

        $payload = [
            'anggota_id' => $anggota->id,
            'komik_id' => $komik->id,
            'tanggal_peminjaman' => now()->toDateString(),
        ];

        $response = $this->postJson('/api/peminjaman', $payload);

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'message' => 'Peminjaman berhasil dibuat',
                     'status' => 'dipinjam',
                 ]);

        $this->assertDatabaseHas('peminjaman', [
            'anggota_id' => $anggota->id,
            'komik_id' => $komik->id,
            'status' => 'dipinjam',
        ]);
        
        // Assert stok berkurang
        $this->assertDatabaseHas('komiks', [
            'id' => $komik->id,
            'stok' => 4,
        ]);
    }

    public function test_validation_fails_on_create_peminjaman(): void
    {
        $response = $this->postJson('/api/peminjaman', []);

        $response->assertStatus(422)
                 ->assertJsonStructure([
                     'message',
                 ]);
    }

    public function test_cannot_create_peminjaman_when_stok_empty(): void
    {
        $anggota = Anggota::factory()->create();
        $komik = Komik::factory()->create(['stok' => 0]);

        $payload = [
            'anggota_id' => $anggota->id,
            'komik_id' => $komik->id,
            'tanggal_peminjaman' => now()->toDateString(),
        ];

        $response = $this->postJson('/api/peminjaman', $payload);

        $response->assertStatus(400)
                 ->assertJsonFragment([
                     'success' => false,
                     'message' => 'Stok komik habis',
                 ]);
    }

    public function test_can_show_peminjaman(): void
    {
        $peminjaman = Peminjaman::factory()->create();

        $response = $this->getJson("/api/peminjaman/{$peminjaman->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'message' => 'Detail peminjaman berhasil diambil.',
                     'id' => $peminjaman->id,
                 ]);
    }

    public function test_can_update_peminjaman(): void
    {
        $peminjaman = Peminjaman::factory()->create(['status' => 'dipinjam']);

        $payload = [
            'status' => 'telat',
        ];

        $response = $this->putJson("/api/peminjaman/{$peminjaman->id}", $payload);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'message' => 'Peminjaman berhasil diupdate.',
                     'status' => 'telat',
                 ]);

        $this->assertDatabaseHas('peminjaman', [
            'id' => $peminjaman->id,
            'status' => 'telat',
        ]);
    }

    public function test_can_delete_peminjaman(): void
    {
        $peminjaman = Peminjaman::factory()->create();

        $response = $this->deleteJson("/api/peminjaman/{$peminjaman->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'message' => 'Peminjaman berhasil dihapus.',
                 ]);

        $this->assertDatabaseMissing('peminjaman', [
            'id' => $peminjaman->id,
        ]);
    }

    public function test_can_kembalikan_peminjaman(): void
    {
        $komik = Komik::factory()->create(['stok' => 2]);
        $peminjaman = Peminjaman::factory()->create([
            'komik_id' => $komik->id,
            'status' => 'dipinjam'
        ]);

        $response = $this->putJson("/api/peminjaman/{$peminjaman->id}/kembali");

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'message' => 'Peminjaman berhasil dikembalikan.',
                     'status' => 'dikembalikan',
                 ]);

        $this->assertDatabaseHas('peminjaman', [
            'id' => $peminjaman->id,
            'status' => 'dikembalikan',
        ]);

        // Cek stok kembali
        $this->assertDatabaseHas('komiks', [
            'id' => $komik->id,
            'stok' => 3,
        ]);
    }
}
