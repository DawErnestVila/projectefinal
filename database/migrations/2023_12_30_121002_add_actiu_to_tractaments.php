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
        Schema::table('tractaments', function (Blueprint $table) {
            $table->boolean('actiu')->default(true)->after('durada');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('tractaments', function (Blueprint $table) {
            $table->dropColumn('actiu');
        });
    }
};
