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

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/personal', 'PersonalController@index');
Route::post('/personal', 'PersonalController@save');

Route::get('/registration', 'RegistrationController@index');
Route::post('/registration', 'RegistrationController@save');

Route::get('/sport', 'SportController@index');
Route::post('/sport', 'SportController@save');

Route::get('/service', 'ServiceController@index');
Route::post('/service', 'ServiceController@save');

Route::get('/summary', 'SummaryController@index');
Route::post('/summary', 'SummaryController@save');

Route::get('/payment', 'PaymentController@index');
Route::post('/payment', 'PaymentController@save');

