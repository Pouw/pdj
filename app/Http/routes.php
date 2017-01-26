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
Route::get('/home', function () {
    return redirect('/');
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
Route::get('/payment-redirect', 'PaymentController@paymentRedirect');
Route::get('/payment-return', 'PaymentController@paymentReturn');
Route::post('/payment', 'PaymentController@save');

Route::get('/admin', 'AdminController@index');
Route::get('/admin/registrations', 'AdminController@registrations');
Route::get('/admin/registration', 'AdminController@registration');
Route::post('/admin/registration', 'AdminController@registrationSave');
Route::get('/admin/users', 'AdminController@users');
Route::get('/admin/user', 'AdminController@user');
Route::get('/admin/payments', 'AdminController@payments');
Route::post('/admin/payment/add', 'AdminController@paymentAdd');
Route::post('/admin/note/add', 'AdminController@noteAdd');
Route::get('/admin/mail-test', 'AdminController@mailTest');
