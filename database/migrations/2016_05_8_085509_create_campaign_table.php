<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign', function (Blueprint $table) {
            $table->incremens('id');
            $table->string('campaign_name');
            $table->string('ad_name');
            $table->string('video_url');
            $table->string('video_size');
            $table->int('video_plays');
            $table->float('revenue');
            $table->string('active');
           
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('campaign');
    }
}
