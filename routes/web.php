<?php

use App\Http\Controllers\BlockchainController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/{any}', fn () => view('app'))->where('any', '.*');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

Route::prefix('blockchain')->group(function () {
    Route::get('show', [BlockchainController::class, 'show']);
    Route::post('create', [BlockchainController::class, 'create']);
});
