<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("peminjaman", function (Blueprint $table) {
            $table->id();
            $table->foreignId("anggota_id")->constrained("anggotas")->cascadeOnDelete();
            $table->foreignId("komik_id")->constrained("komiks")->cascadeOnDelete();
            $table->date("tanggal_peminjaman");
            $table->date("tanggal_pengembalian")->nullable();
            $table
                ->enum("status", ["dipinjam", "dikembalikan", "telat"])
                ->default("dipinjam");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("peminjaman");
    }
};
