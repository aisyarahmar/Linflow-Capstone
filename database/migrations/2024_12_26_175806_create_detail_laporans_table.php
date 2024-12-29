<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_laporans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_laporan_harian');
            $table->unsignedBigInteger('id_stok_komponen');
            $table->integer('stok_awal');
            $table->integer('stok_masuk');
            $table->integer('stok_keluar');
            $table->integer('stok_akhir');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('id_laporan_harian')->references('id')->on('laporan_harians')->onDelete('cascade');
            $table->foreign('id_stok_komponen')->references('id')->on('stok_komponens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_laporans');
    }
};
