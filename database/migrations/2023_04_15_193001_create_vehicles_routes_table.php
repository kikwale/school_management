<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles_routes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schools_id');
            $table->foreign('schools_id')->references('id')->on('schools')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->unsignedBigInteger('vehicles_id');
            $table->foreign('vehicles_id')->references('id')->on('vehicles')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('routes_stations_id');
            $table->foreign('routes_stations_id')->references('id')->on('routes_stations')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles_routes');
    }
}
