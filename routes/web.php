<?php

use Illuminate\Support\Facades\Route;
Route::get('/', function(){
    return view('login');
});
Route::get('/create', function(){
    return view('create');
});
Route::get('/recuperar', function(){
    return view('contrasena');
});

Route::post('/login', 'AuthController@login')->name('login');
Route::post('/crear', 'NewController@nuevo')->name('crear');
Route::post('/nueva', 'ContraseñaController@contra')->name('contra');
Route::post('/confirmar', 'ContraseñaController@nuevaContra')->name('nuevaContra');
Route::get('/logout', 'AuthController@logout');


Route::group(['middleware' => ['web', 'custom_auth']], function () {
    Route::get('/analisis', 'PagesController@home')->name('home');
    Route::get('/puntos', 'CoordenadasController@puntos')->name('puntito');
    Route::get('/algoritmo', 'CoordenadasController@algoritmo')->name('kmeans');
});


//Route::get('/analisis', 'PagesController@home')->name('home');
//Route::get('/puntos', 'CoordenadasController@puntos')->name('puntito');
//Route::get('/algoritmo', 'CoordenadasController@algoritmo')->name('kmeans');
Route::get('/servicioKmeans', 'CoordenadasController@servicioKmeans')->name('kmeans');

// Prediction routers
Route::group(['middleware' => ['web', 'custom_auth']], function(){
    Route::get('/prediction', 'PagesController@prediction')->name('prediction');
    Route::get('/getprediction', 'PredictionController@getprediction')->name('getprediction');
});