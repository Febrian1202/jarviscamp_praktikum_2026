<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::all();

        return $this->successResponse($kategori, "List Kategori", 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "nama_kategori" => "required|string|max:255",
        ]);

        $kategori = Kategori::create($validated);

        return $this->successResponse(
            $kategori,
            "Kategori berhasil dibuat",
            201,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return $this->errorResponse(null, "Kategori tidak ditemukan", 404);
        }

        return $this->successResponse($kategori, "Kategori ditemukan", 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return $this->errorResponse(null, "Kategori tidak ditemukan", 404);
        }

        $validated = $request->validate([
            "nama_kategori" => "sometimes|string|max:255",
        ]);

        $kategori->update($validated);

        return $this->successResponse(
            $kategori,
            "Kategori berhasil di update",
            200,
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return $this->errorResponse(null, "Kategori tidak ditemukan", 404);
        }

        $kategori->delete();

        return $this->successResponse(null, "Kategori berhasil dihapus");
    }
}
