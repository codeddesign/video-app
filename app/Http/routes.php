<?php

Route::controller('/auth', 'AuthController');

Route::controller('/account', 'AccountController');

Route::controller('/campaign', 'CampaignController');

Route::controller('/track', 'TrackController');

Route::controller('/', 'AdminController');