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
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id_member');
            $table->string('Firstname');
            $table->string('LastName')->nullable();;
            $table->string('email')->unique();
            $table->string('password');
            $table->string('profile', 255)->nullable();
            $table->string('Phone', 10)->nullable();;
            $table->enum('status', ['ผู้อ่าน', 'ผู้เขียน', 'ผู้เขียนและผู้อ่าน'])->default('ผู้อ่าน');
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
        Schema::dropIfExists('members');
    }
};
