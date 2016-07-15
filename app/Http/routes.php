<?php

Route::controller('/account', 'AccountController');

Route::controller('/campaign', 'CampaignController');

Route::controller('/track', 'TrackController');

Route::controller('/website-config', 'WebsiteConfigController');

Route::controller('/plugin', 'PluginController');

Route::controller('/dashboard', 'DashboardController');

Route::get('/token', function () {
    return ['token' => csrf_token()];
});

Route::get('/', function () {
    return view('home.index');
});
