<?php

Route::controller('/account', 'AccountController');

Route::controller('/campaign', 'CampaignController');

Route::controller('/track', 'TrackController');

Route::controller('/wordpress', 'WordpressController');

Route::controller('/plugin', 'PluginController');

Route::controller('/', 'DashboardController');
