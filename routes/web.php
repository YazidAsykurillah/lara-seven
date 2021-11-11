<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Role
Route::get('role/datatables', 'Datatables\RoleDatatablesController@index');
Route::post('role/update-permission', 'RoleController@updatePermission');
Route::post('role/delete', 'RoleController@delete');
Route::resource('role', 'RoleController');

//Permission
Route::get('permission/datatables', 'Datatables\PermissionDatatablesController@index');
Route::post('permission/delete', 'PermissionController@delete');
Route::resource('permission', 'PermissionController');

//User
Route::get('user/datatables', 'Datatables\UserDatatablesController@index');
Route::resource('user','UserController');