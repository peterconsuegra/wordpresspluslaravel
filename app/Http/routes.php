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


Route::get('/world', 'hello@world');

Route::get('/', array('as' => 'hello.world', 'uses' => 'hello@world'));

/*
Route::get('/', function () {
    return view('welcome');
});
*/