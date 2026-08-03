<?php

namespace App\Http\Controllers;

use App\Http\Requests\Kategori\StoreKategoriRequest;
use App\Http\Requests\Kategori\UpdateKategoriRequest;
use App\Http\Resources\KategoriResource;
use App\Models\Kategori;
use App\Traits\ApiResponse;

class KategoriController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::all();

        return $this->successResponse(
            KategoriResource::collection($kategori),
            "List Kategori",
            200,
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKategoriRequest $request)
    {
        $validated = $request->validated();

        $kategori = Kategori::create($validated);

        return $this->successResponse(
            new KategoriResource($kategori),
            "Kategori berhasil dibuat",
            201,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kategori = Kategori::findOrFail($id);

        return $this->successResponse(
            new KategoriResource($kategori),
            "Kategori ditemukan",
            200,
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKategoriRequest $request, string $id)
    {
        $kategori = Kategori::findOrFail($id);

        $validated = $request->validated();

        $kategori->update($validated);

        return $this->successResponse(
            new KategoriResource($kategori),
            "Kategori berhasil di update",
            200,
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = Kategori::findOrFail($id);

        $kategori->delete();

        return $this->successResponse(null, "Kategori berhasil dihapus");
    }
}
