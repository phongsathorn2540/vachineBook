<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
 */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('booking', 'BookingController@createBooking');
$router->post('checkemail', 'BookingController@checkEmail');
$router->post('checkphone', 'BookingController@checkPhone');
$router->post('checkidcard', 'BookingController@checkIdCard');
$router->post('createotp', 'OtpController@createOTP');
$router->post('confirmotp', 'OtpController@confirmOTP');
$router->get('booking/{phone}', 'BookingController@getBookingbyUser');
$router->get('bookingdetail/{id}', 'BookingController@bookingDetail');
$router->post('loginbyotp', 'OtpController@loginbyOTP');
$router->post('updateprofile', 'UserController@updateProfile');
$router->get('stats', 'BookingController@stats');