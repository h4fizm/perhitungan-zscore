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
        Schema::create('bbtb-laki-laki', function (Blueprint $table) {
            $table->id();
            $table->decimal('TB', 5, 1); // TB sebagai primary key dengan tipe decimal
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
        Schema::dropIfExists('bbtb-laki-laki');
    }
};
