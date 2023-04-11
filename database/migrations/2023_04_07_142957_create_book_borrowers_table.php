<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookBorrowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_borrowers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schools_id');
            $table->foreign('schools_id')->references('id')->on('schools')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('books_id');
            $table->foreign('books_id')->references('id')->on('books')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('library_users_id');
            $table->foreign('library_users_id')->references('id')->on('library_users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->date('borrowing_date');
            $table->date('returning_date');
            $table->boolean('isReturned')->default(false);
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
        Schema::dropIfExists('book_borrowers');
    }
}
