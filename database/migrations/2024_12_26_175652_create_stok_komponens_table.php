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
        Schema::create('stok_komponens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_komponen');
            $table->integer('stok');
            $table->timestamps(); // update_at juga tercatat otomatis

            // Foreign key constraint
            $table->foreign('id_komponen')->references('id')->on('komponens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_komponens');
    }
};
