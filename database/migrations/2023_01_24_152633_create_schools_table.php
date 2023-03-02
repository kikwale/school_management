<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manager_id');
            $table->foreign('manager_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('school_name');
            $table->string('country');
            $table->string('region');
            $table->string('district');
            $table->string('street')->nullable();
            $table->string('scool_number')->unique();
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
        Schema::dropIfExists('schools');
    }
}
