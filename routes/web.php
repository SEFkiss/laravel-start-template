<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Routes group for admin
Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function () {
    Route::get('/', 'Dashboard\DashboardController@index');
    Route::group(['middleware' => ['role:admin']], function () {
        Route::resource('users', 'Rbac\UsersController');
        Route::resource('permission', 'Rbac\PermissionController');
        Route::resource('roles', 'Rbac\RolesController');
    });    
});

Auth::routes();