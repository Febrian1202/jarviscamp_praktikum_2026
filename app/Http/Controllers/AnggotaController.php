<?php

namespace App\Http\Controllers;

use App\Http\Requests\Anggota\StoreAnggotaRequest;
use App\Http\Requests\Anggota\UpdateAnggotaRequest;
use App\Http\Resources\AnggotaResource;
use App\Models\Anggota;
use App\Traits\ApiResponse;

class AnggotaController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $anggota = Anggota::all();

        return $this->successResponse(
            AnggotaResource::collection($anggota),
            "List anggota",
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnggotaRequest $request)
    {
        $validated = $request->validated();

        $anggota = Anggota::create($validated);

        return $this->successResponse(
            new AnggotaResource($anggota),
            "Berhasil membuat data anggota",
            201,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $anggota = Anggota::findOrFail($id);

        return $this->successResponse(
            new AnggotaResource($anggota),
            "Berhasil mengambil data anggota",
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnggotaRequest $request, string $id)
    {
        $anggota = Anggota::findOrFail($id);

        $validated = $request->validated();

        $anggota->update($validated);

        return $this->successResponse(
            new AnggotaResource($anggota),
            "Data anggota berhasil diupdate",
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $anggota = Anggota::findOrFail($id);

        $anggota->delete();

        return $this->successResponse(null, "Anggota berhasil dihapus");
    }
}
