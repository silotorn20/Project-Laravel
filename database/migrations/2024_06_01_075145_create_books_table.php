<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('books')) {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id_book');
            $table->unsignedBigInteger('id_setbook');
            $table->unsignedInteger('id_member');
            $table->string('name_book', 50)->notNull();
            $table->string('image_book', 255)->notNull();
            $table->string('file_book', 255)->notNull();
            $table->integer('price')->notNull();
            $table->integer('amount_page')->notNull();

               $table->foreign('id_setbook')->references('id_setbook')->on('set_books')->onDelete('cascade');
            $table->foreign('id_member')->references('id_member')->on('members')->onDelete('cascade');
        });
    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');

    }
};
