<?php

Route::controller('/account', 'AccountController');

Route::controller('/campaign', 'CampaignController');

Route::controller('/wordpress', 'WordpressController');

Route::controller('/track', 'TrackController');

Route::controller('/', 'DashboardController');