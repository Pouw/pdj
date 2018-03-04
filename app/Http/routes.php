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

Route::get('/', 'HomeController@index');
Route::get('/closed', 'GuestController@closed');
Route::get('/home', function () {
    return redirect('/');
});

Route::auth();

Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/personal', 'PersonalController@index');
Route::post('/personal', 'PersonalController@saveNext');
Route::get('/personal/single', 'PersonalController@index');
Route::post('/personal/single', 'PersonalController@saveSingle');

Route::get('/registration', 'RegistrationController@index');
Route::post('/registration', 'RegistrationController@save');

Route::get('/sport', 'SportController@index');
Route::post('/sport', 'SportController@save');

Route::get('/service', 'ServiceController@index');
Route::post('/service', 'ServiceController@save');

Route::get('/summary', 'SummaryController@index');
Route::get('/summary/single', 'SummaryController@index');
Route::post('/summary', 'SummaryController@save');

Route::get('/payment', 'PaymentController@index');
Route::get('/payment/single', 'PaymentController@index');
Route::post('/payment', 'PaymentController@save');
Route::get('/payment/redirect', 'PaymentController@paymentRedirect');
Route::post('/payment/return', 'PaymentController@paymentReturn');

Route::get('/admin', 'AdminController@index');
Route::get('/admin/registration/id/{id}', 'Admin\RegistrationController@edit');
Route::post('/admin/registration/id/{id}', 'Admin\RegistrationController@save');
Route::get('/admin/registration/overview', 'Admin\RegistrationController@overview');
Route::get('/admin/registration/list', 'Admin\RegistrationController@list');
Route::get('/admin/registration/log/{id}', 'Admin\RegistrationController@log');
Route::get('/admin/registration/check-paid', 'Admin\RegistrationController@checkPaid');
Route::post('/admin/registration/add-note', 'Admin\RegistrationController@noteAdd');
Route::get('/admin/users', 'AdminController@users');
Route::get('/admin/user', 'AdminController@user');
Route::get('/admin/payment/list', 'Admin\PaymentController@list');
Route::get('/admin/payment/test', 'Admin\PaymentController@test');
Route::post('/admin/payment/add', 'AdminController@paymentAdd');
Route::get('/admin/mail-test', 'AdminController@mailTest');
Route::get('/admin/exports', 'AdminController@exports');
Route::get('/admin/export', 'AdminController@export');
Route::get('/admin/fix-paid', 'AdminController@fixPaid');
Route::get('/admin/emails', 'Admin\EmailsController@index');
Route::get('/admin/emails/preview', 'Admin\EmailsController@preview');
Route::get('/admin/emails/send-schedule-email', 'Admin\EmailsController@sendScheduleEmail');
Route::post('/admin/emails/send', 'Admin\EmailsController@send');
Route::get('/admin/incomes', 'Admin\IncomesController@index');

Route::get('/cron/email', 'CronController@email');
