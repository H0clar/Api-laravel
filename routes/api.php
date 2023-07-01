<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;


Route::get('pacientes', 'App\Http\Controllers\PacienteController@index');
Route::post('pacientes', 'App\Http\Controllers\PacienteController@store');
Route::get('pacientes/{id}', 'App\Http\Controllers\PacienteController@show');
Route::put('pacientes/{id}', 'App\Http\Controllers\PacienteController@update');
Route::delete('pacientes/{id}', 'App\Http\Controllers\PacienteController@destroy');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});