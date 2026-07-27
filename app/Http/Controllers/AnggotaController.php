<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $anggota = Anggota::all();

        return response()->json(
            [
                'message' => 'List anggota',
                'data' => $anggota,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'tanggal_daftar' => 'required|date',
        ]);

        $anggota = Anggota::create($validated);

        return response()->json(
            [
                'message' => 'Berhasil membuat data anggota',
                'data' => $anggota,
            ],
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $anggota = Anggota::find($id);

        if (! $anggota) {
            return response()->json(
                [
                    'message' => 'Anggota tidak ditemukan',
                    'data' => null,
                ],
                404
            );
        }

        return response()->json([
            'message' => 'Berhasil mengambil data anggota',
            'data' => $anggota,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $anggota = Anggota::find($id);

        if (! $anggota) {
            return response()->json(
                [
                    'message' => 'Anggota tidak ditemukan',
                    'data' => null,
                ],
                404
            );
        }

        $validated = $request->validate([
            'nama' => 'sometimes|string|max:255',
            'no_hp' => 'sometimes|string|max:255',
            'alamat' => 'sometimes|string',
            'tanggal_daftar' => 'sometimes|date',
        ]);

        $anggota->update($validated);

        return response()->json(
            [
                'message' => 'Data anggota berhasil diupdate',
                'data' => $anggota,
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $anggota = Anggota::find($id);

        if (! $anggota) {
            return response()->json(
                [
                    'message' => 'Anggota tidak ditemukan',
                    'data' => null,
                ],
                404
            );
        }

        $anggota->delete();

        return response()->json(
            [
                'message' => 'Anggota berhasil dihapus',
                'data' => null,
            ]
        );
    }
}
