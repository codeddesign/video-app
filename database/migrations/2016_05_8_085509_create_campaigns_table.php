<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')
                ->unsigned()
                ->references('id')->on('users');

            $table->string('campaign_name')->index();

            $table->string('ad_name')->nullable()->index(); // todo

            $table->string('video_url')->index();

            $table->integer('video_width')->index();
            $table->integer('video_height')->index();

            $table->integer('video_plays')->index();
            $table->float('revenue')->index();

            $table->string('active')->index();

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
        Schema::drop('campaigns');
    }
}
