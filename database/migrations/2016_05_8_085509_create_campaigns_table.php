<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')
                ->unsigned()->references('id')->on('users');

            $table->string('name')->index();

            $table->string('type')->index();

            $table->integer('rpm')->default(0)->index();

            $table->string('size')->default('auto')->index();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('campaigns');
    }
}
