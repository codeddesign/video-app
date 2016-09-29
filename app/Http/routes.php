<?php

Route::group(['prefix' => '/app', 'middleware' => 'app-dashboard'], function () {
    Route::controller('/website-config', 'WebsiteConfigController');

    Route::controller('/campaign', 'CampaignController');

    Route::controller('/profile', 'ProfileController');

    Route::controller('/', 'AppController');
});

Route::controller('/track', 'TrackController');

Route::controller('/plugin', 'PluginController');

Route::controller('/', 'HomeController');
