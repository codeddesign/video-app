<?php

Route::controller('/account', 'AccountController');

Route::controller('/campaign', 'CampaignController');

Route::controller('/track', 'TrackController');

Route::controller('/website-config', 'WebsiteConfigController');

Route::controller('/plugin', 'PluginController');

Route::controller('/dashboard', 'DashboardController');

Route::get('/', function () {
    return view('home.index');
});
