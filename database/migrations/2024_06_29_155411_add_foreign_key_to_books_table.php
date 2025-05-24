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
        Schema::table('books', function (Blueprint $table) {
            // Check if the column 'id_setbook' does not exist before adding
            if (!Schema::hasColumn('books', 'id_setbook')) {
                $table->unsignedBigInteger('id_setbook')->notNull()->after('id_book');
                $table->foreign('id_setbook')->references('id_setbook')->on('set_books')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['id_setbook']); // Drop the foreign key constraint
            $table->dropColumn('id_setbook'); // Drop the column
        });
    }
};
