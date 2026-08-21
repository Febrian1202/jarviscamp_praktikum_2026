<?php

namespace Tests\Unit;

use App\Models\Anggota;
use App\Models\Komik;
use App\Models\Peminjaman;
use App\Services\PeminjamanService;
use DomainException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RuntimeException;
use Tests\TestCase;

class PeminjamanServiceTest extends TestCase
{
    use RefreshDatabase;

    private PeminjamanService $peminjamanService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->peminjamanService = new PeminjamanService();
    }

    public function test_can_create_peminjaman_and_reduce_stok()
    {
        $anggota = Anggota::factory()->create();
        $komik = Komik::factory()->create(['stok' => 5]);

        $data = [
            'anggota_id' => $anggota->id,
            'komik_id' => $komik->id,
            'tanggal_peminjaman' => now()->toDateString(),
        ];

        $peminjaman = $this->peminjamanService->createPeminjaman($data);

        $this->assertInstanceOf(Peminjaman::class, $peminjaman);
        $this->assertEquals('dipinjam', $peminjaman->status);
        
        // Cek stok komik berkurang
        $komik->refresh();
        $this->assertEquals(4, $komik->stok);

        // Cek database
        $this->assertDatabaseHas('peminjaman', [
            'anggota_id' => $anggota->id,
            'komik_id' => $komik->id,
            'status' => 'dipinjam',
        ]);
    }

    public function test_cannot_create_peminjaman_when_stok_empty()
    {
        $anggota = Anggota::factory()->create();
        $komik = Komik::factory()->create(['stok' => 0]);

        $data = [
            'anggota_id' => $anggota->id,
            'komik_id' => $komik->id,
            'tanggal_peminjaman' => now()->toDateString(),
        ];

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Stok komik habis');

        $this->peminjamanService->createPeminjaman($data);
    }

    public function test_can_kembalikan_peminjaman_and_increase_stok()
    {
        $anggota = Anggota::factory()->create();
        $komik = Komik::factory()->create(['stok' => 2]);

        $peminjaman = Peminjaman::factory()->create([
            'anggota_id' => $anggota->id,
            'komik_id' => $komik->id,
            'status' => 'dipinjam'
        ]);

        $returnedPeminjaman = $this->peminjamanService->pengembalian($peminjaman);

        $this->assertEquals('dikembalikan', $returnedPeminjaman->status);
        $this->assertEquals(now()->toDateString(), $returnedPeminjaman->tanggal_pengembalian);

        // Cek stok komik bertambah
        $komik->refresh();
        $this->assertEquals(3, $komik->stok);
    }

    public function test_cannot_kembalikan_already_returned_komik()
    {
        $anggota = Anggota::factory()->create();
        $komik = Komik::factory()->create();

        $peminjaman = Peminjaman::factory()->create([
            'anggota_id' => $anggota->id,
            'komik_id' => $komik->id,
            'status' => 'dikembalikan'
        ]);

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Komik ini sudah dikembalikan sebelumnya.');

        $this->peminjamanService->pengembalian($peminjaman);
    }
}
