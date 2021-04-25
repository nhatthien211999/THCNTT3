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
    return view('trangchu');
})->middleware('auth');


Route::get('firebase/index','App\Http\Controllers\FirebaseController@index');
Route::get('firebase/switch','App\Http\Controllers\FirebaseController@switch');
Route::get('firebase/getAll','App\Http\Controllers\FirebaseController@getAll');
Route::get('firebase/view','App\Http\Controllers\FirebaseController@View');
Route::get('firebase/delete','App\Http\Controllers\FirebaseController@delete');
Route::get('firebase/schedule','App\Http\Controllers\FirebaseController@changeSchedule');
Route::get('firebase/broken','App\Http\Controllers\FirebaseController@broken');


Route::get('admin/addHome','App\Http\Controllers\adminController@addHome');
Route::get('admin/home','App\Http\Controllers\adminController@view');
Route::get('admin/user','App\Http\Controllers\adminController@user');
Route::get('admin/lightsUser/{id?}','App\Http\Controllers\adminController@lightsUser');




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
