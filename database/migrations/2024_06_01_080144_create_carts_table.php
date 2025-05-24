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
        if (!Schema::hasTable('carts')) {
        Schema::create('carts', function (Blueprint $table) {
            $table->increments('id_cart');
            $table->string('image_cart', 255)->notNull();
            $table->date('date')->notNull();
            $table->integer('sum_price')->notNull();
            $table->integer('status')->notNull();
            $table->integer('id_book')->unsigned()->notNull();
            $table->integer('id_member')->unsigned()->notNull();

            // Foreign key constraints
            $table->foreign('id_book')->references('id_book')->on('books')->onDelete('cascade');
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
        Schema::dropIfExists('carts');
    }
};
