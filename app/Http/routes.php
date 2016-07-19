<?php

/**
 * Temporary controller to show stats.
 */
Route::controller('/stats-101', 'StatsController');

Route::group(['prefix' => '/app'], function () {
    Route::controller('/website-config', 'WebsiteConfigController');

    Route::controller('/campaign', 'CampaignController');

    Route::controller('/profile', 'ProfileController');

    Route::controller('/', 'AppController');
});

Route::controller('/track', 'TrackController');

Route::controller('/plugin', 'PluginController');

Route::controller('/', 'HomeController');
