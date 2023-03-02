<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWazazisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wazazis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('schools_id');
            $table->foreign('schools_id')->references('id')->on('schools')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('address');
            $table->string('employment_status');
            $table->string('institute')->nullable();
            $table->string('position')->nullable();
            $table->string('work')->nullable();
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
        Schema::dropIfExists('parents');
    }
}
