<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::group(
    [
        'namespace'  => 'App\Http\Controllers',
    ],
    function ($router) {
        Route::post('login', 'AuthController@login')->name('login');
        Route::post('register', 'AuthController@register');
        Route::post('logout', 'AuthController@logout');
        Route::get('profile', 'AuthController@profile');
        Route::post('profileUpdate', 'AuthController@profileUpdate');
        Route::post('refresh', 'AuthController@refresh');
        
    }
);


Route::group(
    [   
        'middleware' => 'auth:api',
        'namespace'  => 'App\Http\Controllers',
    ],
    function ($router) {
        Route::resource('book', 'BookController');
        Route::get('rentedbooks', 'RentController@index');
        Route::post('rentbook', 'RentController@rentBook');
        Route::post('returnbook', 'RentController@returnBook');
    }
);



