<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up()
    // {
    //     Schema::table('historials', function (Blueprint $table) {
    //         $table->string('client_name');
    //         $table->string('tractament_name');
    //         $table->string('user_name');
    //         // Altres canvis necessaris
    //     });
    // }

    public function down()
    {
        Schema::table('historials', function (Blueprint $table) {
            $table->dropColumn('client_id');
            $table->dropColumn('tractament_id');
            $table->dropColumn('user_id');
            $table->dropColumn('client_name');
            $table->dropColumn('tractament_name');
            $table->dropColumn('user_name');
            // Altres canvis necessaris per desfer els canvis
        });
    }
};
