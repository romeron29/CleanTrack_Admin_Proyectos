<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\InmuebleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('clientes', ClienteController::class)->only(['index', 'create', 'store']);

Route::resource('clientes.inmuebles', InmuebleController::class)->only(['index', 'create', 'store']);
