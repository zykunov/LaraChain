<?php

use App\Services\Block\BlockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlockchainController;


Route::prefix('blockchain')->group(function () {
    Route::get('show', [BlockchainController::class, 'show']);
    Route::post('create', [BlockchainController::class, 'create']);
    Route::get('/chains', [BlockchainController::class, 'allChains']);
    Route::get('/chain/{id}', [BlockchainController::class, 'getBlocksByChainId']);
    Route::post('/blockAdd', [BlockchainController::class, 'addBlock']);
});


