<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('historials', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('tractament_name');
            $table->string('user_name');
            $table->date('data');
            $table->time('hora');
            $table->date('data_cancelacio')->nullable();
            $table->text('motiu_cancelacio')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('historials', function (Blueprint $table) {
            $table->dropColumn('client_id');
            $table->dropColumn('tractament_id');
            $table->dropColumn('user_id');
            // Altres canvis necessaris per desfer els canvis
        });
    }
};
