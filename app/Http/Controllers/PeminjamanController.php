<?php

namespace App\Http\Controllers;

use App\Http\Requests\Peminjaman\StorePeminjamanRequest;
use App\Http\Requests\Peminjaman\UpdatePeminjamanRequest;
use App\Http\Resources\PeminjamanResource;
use App\Interfaces\PeminjamanServiceInterface;
use App\Models\Peminjaman;
use App\Traits\ApiResponse;
use DomainException;
use RuntimeException;

class PeminjamanController extends Controller
{
    use ApiResponse;

    /**
     * Constructor for PeminjamanController.
     */
    public function __construct(private PeminjamanServiceInterface $peminjamanService) {}

    /**
     * Menampilkan daftar peminjaman.
     */
    public function index()
    {
        $peminjaman = $this->peminjamanService->getAll();

        return $this->successResponse(
            PeminjamanResource::collection($peminjaman),
            'Daftar peminjaman berhasil diambil.',
        );
    }

    public function store(StorePeminjamanRequest $request)
    {
        try {
            $peminjaman = $this->peminjamanService->createPeminjaman(
                $request->validated(),
            );
        } catch (RuntimeException $e) {
            return $this->errorResponse(null, $e->getMessage(), 400);
        }

        return $this->successResponse(
            new PeminjamanResource($peminjaman),
            'Peminjaman berhasil dibuat',
            201,
        );
    }

    public function show(Peminjaman $peminjaman)
    {
        $data = $this->peminjamanService->getById($peminjaman);

        return $this->successResponse(
            new PeminjamanResource($data),
            'Detail peminjaman berhasil diambil.',
            200,
        );
    }

    public function update(UpdatePeminjamanRequest $request, Peminjaman $peminjaman)
    {
        $peminjaman = $this->peminjamanService->updatePeminjaman(
            $peminjaman,
            $request->validated(),
        );

        return $this->successResponse(
            new PeminjamanResource($peminjaman),
            'Peminjaman berhasil diupdate.',
            200,
        );
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $this->peminjamanService->deletePeminjaman($peminjaman);

        return $this->successResponse(
            null,
            'Peminjaman berhasil dihapus.',
            200,
        );
    }

    public function kembali(Peminjaman $peminjaman)
    {
        try {
            // code...
            $peminjaman = $this->peminjamanService->pengembalian($peminjaman);
        } catch (DomainException $e) {
            // throw $th;
            return $this->errorResponse(null, $e->getMessage(), 400);
        }

        return $this->successResponse(
            new PeminjamanResource($peminjaman),
            'Peminjaman berhasil dikembalikan.',
            200,
        );
    }
}
