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

Route::get('/', 'Auth\LoginController@showLoginForm');
Route::get('/logout', 'Auth\LoginController@logout');


Route::get('clientes', 'ClientesController@index')->name('clientes')->middleware('auth');

Route::get('clientes/getdata', 'ClientesController@getdata')->name('clientes.getdata')->middleware('auth');

Route::post('clientes/postdata', 'ClientesController@postdata')->name('clientes.postdata')->middleware('auth');

Route::get('clientes/fetchdata', 'ClientesController@fetchdata')->name('clientes.fetchdata')->middleware('auth');

Route::get('clientes/removedata', 'ClientesController@removedata')->name('clientes.removedata')->middleware('auth');


Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('home')->middleware('auth');

Route::get('message/{id}', 'HomeController@getMessage')->name('message')->middleware('auth');

Route::post('message', 'HomeController@sendMessage')->middleware('auth');

Route::get('dashboard/getdata', 'HomeController@getdata')->name('dashboard.getdata')->middleware('auth');

Route::get('dashboard/fetchdata', 'HomeController@fetchdata')->name('dashboard.fetchdata')->middleware('auth');

Route::get('dashboard/fetchdatatable', 'HomeController@fetchdatatable')->name('dashboard.fetchdatatable')->middleware('auth');

Route::post('postdataPos', 'HomeController@postdataPos')->middleware('auth');


Route::get('mapas', 'MapasController@index')->name('mapas')->middleware('auth');




Route::get('usuarios', 'UsersController@index')->name('usuarios')->middleware('auth');

Route::get('usuarios/getdata', 'UsersController@getdata')->name('usuarios.getdata')->middleware('auth');

Route::post('usuarios/postdata', 'UsersController@postdata')->name('usuarios.postdata')->middleware('auth');

Route::get('usuarios/fetchdata', 'UsersController@fetchdata')->name('usuarios.fetchdata')->middleware('auth');

Route::get('usuarios/removedata', 'UsersController@removedata')->name('usuarios.removedata')->middleware('auth');



Route::get('servicios', 'ServiciosController@index')->name('servicios')->middleware('auth');

Route::get('servicios/getdata', 'ServiciosController@getdata')->name('servicios.getdata')->middleware('auth');

Route::post('servicios/postdata', 'ServiciosController@postdata')->name('servicios.postdata')->middleware('auth');

Route::get('servicios/fetchdata', 'ServiciosController@fetchdata')->name('servicios.fetchdata')->middleware('auth');

Route::get('servicios/removedata', 'ServiciosController@removedata')->name('servicios.removedata')->middleware('auth');



Route::get('mis-servicios', 'MisServiciosController@index')->name('mis-servicios')->middleware('auth');

Route::get('mis-servicios/getdata', 'MisServiciosController@getdata')->name('mis-servicios.getdata')->middleware('auth');

Route::post('mis-servicios/postdata', 'MisServiciosController@postdata')->name('mis-servicios.postdata')->middleware('auth');

Route::get('mis-servicios/fetchdata', 'MisServiciosController@fetchdata')->name('mis-servicios.fetchdata')->middleware('auth');

Route::get('mis-servicios/getdataCompletado', 'MisServiciosController@getdataCompletado')->name('mis-servicios.getdataCompletado')->middleware('auth');

Route::get('mis-servicios/getdataNoCompletado', 'MisServiciosController@getdataNoCompletado')->name('mis-servicios.getdataNoCompletado')->middleware('auth');

