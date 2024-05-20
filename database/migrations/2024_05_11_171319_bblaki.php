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
        Schema::create('bb-laki-laki', function (Blueprint $table) {
            $table->integer('UMUR')->primary(); // UMUR sebagai primary key
            $table->decimal('N3SD', 8, 2);
            $table->decimal('N2SD', 8, 2);
            $table->decimal('N1SD', 8, 2);
            $table->decimal('MEDIAN', 8, 2);
            $table->decimal('P1SD', 8, 2);
            $table->decimal('P2SD', 8, 2);
            $table->decimal('P3SD', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bblaki');
    }
};
