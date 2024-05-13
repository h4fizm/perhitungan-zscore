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
        Schema::create('pengukuran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pasien');
            $table->foreign('id_pasien')->references('id')->on('pasien')->onDelete('cascade');
            $table->date('tanggal_pengukuran');
            $table->integer('umur'); // Tambahkan kolom umur
            $table->decimal('berat_badan', 8, 2);
            $table->decimal('tinggi_badan', 8, 2);
            $table->enum('status_gizi', ['stunting', 'normal', 'obesitas']);
            $table->enum('status_tinggi', ['pendek', 'normal', 'tinggi']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengukuran');
    }
};
