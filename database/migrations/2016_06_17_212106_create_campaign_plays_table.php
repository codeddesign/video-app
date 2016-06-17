<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCampaignPlaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_plays', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('campaign_id')
                ->unsigned()
                ->references('id')->on('campaigns');

            $table->string('referer');

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
        Schema::drop('campaign_plays');
    }
}
