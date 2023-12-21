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
        Schema::create('horaris', function (Blueprint $table) {
            $table->id();
            $table->integer('dia'); // 1 = Dilluns, 2 = Dimarts, 3 = Dimecres, 4 = Dijous, 5 = Divendres, 6 = Dissabte, 7 = Diumenge
            $table->time('hora_obertura');
            $table->time('hora_tancament');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horaris');
    }
};
