<?php

namespace App\Services;

use App\Interfaces\PeminjamanServiceInterface;
use App\Models\Komik;
use App\Models\Peminjaman;
use DomainException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PeminjamanService implements PeminjamanServiceInterface
{
    public function getAll(): Collection
    {
        return Peminjaman::with(['anggota', 'komik'])->get();
    }

    public function getById(Peminjaman $peminjaman): Peminjaman
    {
        return $peminjaman->load(['anggota', 'komik']);
    }

    public function createPeminjaman(array $data): Peminjaman
    {
        $komik = Komik::findOrFail($data['komik_id']);

        if ($komik->stok <= 0) {
            throw new RuntimeException('Stok komik habis');
        }

        return DB::transaction(function () use ($data, $komik) {
            $peminjaman = Peminjaman::create([
                'anggota_id' => $data['anggota_id'],
                'komik_id' => $data['komik_id'],
                'tanggal_peminjaman' => $data['tanggal_peminjaman'],
                'status' => 'dipinjam',
            ]);

            $komik->decrement('stok');

            return $peminjaman->fresh(['anggota', 'komik']);
        });
    }

    public function updatePeminjaman(Peminjaman $peminjaman, array $data): Peminjaman
    {
        return $peminjaman->update($data) ? $peminjaman->fresh(['anggota', 'komik']) : null;
    }

    public function deletePeminjaman(Peminjaman $peminjaman): void
    {
        $peminjaman->delete();
    }

    public function pengembalian(Peminjaman $peminjaman): Peminjaman
    {
        if ($peminjaman->status === 'dikembalikan') {
            throw new DomainException('Komik ini sudah dikembalikan sebelumnya.');
        }

        return DB::transaction(function () use ($peminjaman) {
            $peminjaman->update([
                'status' => 'dikembalikan',
                'tanggal_kembali' => now()->toDateString(),
            ]);

            Komik::find($peminjaman->komik_id)?->increment('stok');

            return $peminjaman->fresh(['anggota', 'komik']);
        });
    }
}
