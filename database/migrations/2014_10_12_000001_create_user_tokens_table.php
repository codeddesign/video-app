<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTokensTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('user_tokens', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')
                ->unsigned()->references('id')->on('users');

            $table->string('token');

            $table->enum('type', ['confirm', 'reset'])->default('confirm');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('user_tokens');
    }
}
