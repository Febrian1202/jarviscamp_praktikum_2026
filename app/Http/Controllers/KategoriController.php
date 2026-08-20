<?php

namespace App\Http\Controllers;

use App\Http\Requests\Kategori\StoreKategoriRequest;
use App\Http\Requests\Kategori\UpdateKategoriRequest;
use App\Http\Resources\KategoriResource;
use App\Interfaces\KategoriServiceInterface;
use App\Models\Kategori;
use App\Traits\ApiResponse;

class KategoriController extends Controller
{
    use ApiResponse;

    public function __construct(private KategoriServiceInterface $kategoriService) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = $this->kategoriService->getAllKategori();

        return $this->successResponse(
            KategoriResource::collection($kategori),
            'List Kategori',
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKategoriRequest $request)
    {
        $kategori = $this->kategoriService->createKategori(
            $request->validated(),
        );

        return $this->successResponse(
            new KategoriResource($kategori),
            'Kategori berhasil dibuat',
            201,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        return $this->successResponse(
            new KategoriResource($kategori),
            'Kategori ditemukan',
            200,
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKategoriRequest $request, Kategori $kategori)
    {
        $kategori = $this->kategoriService->updateKategori(
            $kategori,
            $request->validated(),
        );

        return $this->successResponse(
            new KategoriResource($kategori),
            'Kategori berhasil di update',
            200,
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        $this->kategoriService->deleteKategori($kategori);

        return $this->successResponse(null, 'Kategori berhasil dihapus');
    }
}
