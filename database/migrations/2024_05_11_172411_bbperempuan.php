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
        Schema::create('bb-perempuan', function (Blueprint $table) {
            $table->integer('umur')->primary(); // Umur sebagai primary key
            $table->decimal('-3SD', 8, 2);
            $table->decimal('-2SD', 8, 2);
            $table->decimal('-1SD', 8, 2);
            $table->decimal('median', 8, 2);
            $table->decimal('1SD', 8, 2);
            $table->decimal('2SD', 8, 2);
            $table->decimal('3SD', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bbperempuan');
    }
};
