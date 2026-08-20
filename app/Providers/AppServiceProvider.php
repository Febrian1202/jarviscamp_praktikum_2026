<?php

namespace App\Providers;

use App\Interfaces\AnggotaServiceInterface;
use App\Interfaces\KategoriServiceInterface;
use App\Interfaces\KomikServiceInterface;
use App\Interfaces\AuthServiceInterface;
use App\Interfaces\PeminjamanServiceInterface;
use App\Services\AuthService;
use App\Services\KomikService;
use App\Services\AnggotaService;
use App\Services\KategoriService;
use App\Services\PeminjamanService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        AuthServiceInterface::class => AuthService::class,
        KomikServiceInterface::class => KomikService::class,
        AnggotaServiceInterface::class => AnggotaService::class,
        KategoriServiceInterface::class => KategoriService::class,
        PeminjamanServiceInterface::class => PeminjamanService::class,
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
