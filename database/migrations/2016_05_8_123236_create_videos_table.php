<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('campaign_id')
                ->unsigned()->references('id')->on('campaigns');

            $table->string('url')->index();

            $table->enum('source', [
                'youtube',
                'vimeo',
                'upload',
                'other',
            ])->default('youtube')->index();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('videos');
    }
}
