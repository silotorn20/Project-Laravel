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
        Schema::create('buy_book', function (Blueprint $table) {
            $table->integer('id_cart')->unsigned();
            $table->integer('id_book')->unsigned();
            $table->date('date')->notNull();
            $table->integer('price')->notNull();

            // Composite primary key
            $table->primary('id_cart');

            // Foreign key constraints
            $table->foreign('id_cart')->references('id_cart')->on('carts')->onDelete('cascade');
            $table->foreign('id_book')->references('id_book')->on('books')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buy_book');
    }
};
