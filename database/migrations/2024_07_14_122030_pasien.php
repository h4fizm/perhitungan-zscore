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
        Schema::create('pasien', function (Blueprint $table) {
            $table->id();
            $table->string('nik');
            $table->string('nama');
            $table->string('alamat');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->unsignedBigInteger('id_location');
            $table->foreign('id_location')->references('id')->on('locations')->onDelete('cascade');
            $table->date('tanggal_pengukuran');
            $table->integer('umur');
            $table->decimal('berat_badan', 8, 2)->default(0);
            $table->decimal('tinggi_badan', 8, 2)->default(0);
            $table->string('status_gizi')->default(''); // Atau nilai default lain yang sesuai
            $table->string('status_tinggi')->default(''); // Atau nilai default lain yang sesuai
            $table->string('kategori')->default(''); // Atau nilai default lain yang sesuai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};
