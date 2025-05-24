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
         if (!Schema::hasTable('members')) {
        Schema::table('members', function (Blueprint $table) {
            $table->enum('status', ['ผู้อ่าน', 'ผู้เขียน', 'ผู้เขียนและผู้อ่าน'])->default('ผู้อ่าน')->after('Phone');
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
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
