<?php

namespace App\Http\Controllers;

use App\Http\Requests\Anggota\StoreAnggotaRequest;
use App\Http\Requests\Anggota\UpdateAnggotaRequest;
use App\Http\Resources\AnggotaResource;
use App\Interfaces\AnggotaServiceInterface;
use App\Models\Anggota;
use App\Traits\ApiResponse;

class AnggotaController extends Controller
{
    use ApiResponse;

    public function __construct(private AnggotaServiceInterface $anggotaService) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $anggota = $this->anggotaService->getAllAnggota();

        return $this->successResponse(
            AnggotaResource::collection($anggota),
            'List anggota',
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnggotaRequest $request)
    {
        $anggota = $this->anggotaService->createAnggota($request->validated());

        return $this->successResponse(
            new AnggotaResource($anggota),
            'Berhasil membuat data anggota',
            201,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Anggota $anggota)
    {
        return $this->successResponse(
            new AnggotaResource($anggota),
            'Berhasil mengambil data anggota',
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnggotaRequest $request, Anggota $anggota)
    {
        $anggota = $this->anggotaService->updateAnggota(
            $anggota,
            $request->validated(),
        );

        return $this->successResponse(
            new AnggotaResource($anggota),
            'Data anggota berhasil diupdate',
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anggota $anggota)
    {
        $this->anggotaService->deleteAnggota($anggota);

        return $this->successResponse(null, 'Anggota berhasil dihapus');
    }
}
