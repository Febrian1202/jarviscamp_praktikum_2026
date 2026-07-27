<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::all();

        return response()->json([
            'message' => 'List Kategori',
            'data' => $kategori,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori = Kategori::create($validated);

        return response()->json(
            [
                'message' => 'Kategori berhasil dibuat',
                'data' => $kategori,
            ],
            201,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kategori = Kategori::find($id);

        if (! $kategori) {
            return response()->json(
                [
                    'message' => 'Kategori tidak ditemukan',
                    'data' => null,
                ],
                404
            );
        }

        return response()->json(
            [
                'message' => 'Kategori ditemukan',
                'data' => $kategori,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kategori = Kategori::find($id);

        if (! $kategori) {
            return response()->json(
                [
                    'message' => 'Kategori tidak ditemukan',
                    'data' => null,
                ],
                404
            );
        }

        $validated = $request->validate([
            'nama_kategori' => 'sometimes|string|max:255',
        ]);

        $kategori->update($validated);

        return response()->json(
            [
                'message' => 'Kategori berhasil di update',
                'data' => $kategori,
            ],
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = Kategori::find($id);

        if (! $kategori) {
            return response()->json(
                [
                    'message' => 'Kategori tidak ditemukan',
                    'data' => null,
                ],
                404
            );
        }

        $kategori->delete();

        return response()->json(
            [
                'message' => 'Kategori berhasil dihapus',
                'data' => null,
            ],
        );
    }
}
