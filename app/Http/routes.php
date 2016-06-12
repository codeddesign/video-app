<?php

Route::controller('/auth', 'AuthController');

Route::controller('/account', 'AccountController');

Route::controller('/campaign', 'CampaignController');

Route::get('/', 'AdminController@index');