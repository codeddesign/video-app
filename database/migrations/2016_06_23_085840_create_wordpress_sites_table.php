<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordpressSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wordpress_sites', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')
                ->unsigned()
                ->references('id')->on('users');

            $table->string('link')
                ->unique()
                ->index();

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
        Schema::drop('wordpress_sites');
    }
}
