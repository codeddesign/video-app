<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//test
// Route::get('/','AdminController@test');
// Route::get('/example','AdminController@example');


//AdminController
Route::get('/','AdminController@index');
Route::get('adminDashboard/{id}','AdminController@adminDashboard');
Route::get('adminCreateCampaign/{id}','AdminController@adminCreateCampaign');
Route::get('adminEditAccount/{id}','AdminController@adminEditAccount');
Route::get('adminLogout','AdminController@adminLogout');
Route::get('adminRegister','AdminController@adminRegister');
Route::get('adminLostPassword','AdminController@adminLostPassword');\
Route::get('adminDeleteCampaign/{id}','AdminController@adminDeleteCampaign');
Route::get('adminEditCampaign/{id}','AdminController@adminEditCampaign');

Route::post('userLogin','AdminController@userLogin');
Route::post('adminChangePassword/{id}','AdminController@adminChangePassword');
Route::post('adminRegisterCheck','AdminController@adminRegisterCheck');
Route::post('adminLostPasswordCheck','AdminController@adminLostPasswordCheck');
Route::post('adminCreateCampaignCheck/{id}','AdminController@adminCreateCampaignCheck');
Route::post('adminSearch/{id}','AdminController@adminSearch');

