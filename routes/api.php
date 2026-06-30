<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CategoryController;

Route::prefix('v1')->group(function () {

    Route::get('categories/trashed', [CategoryController::class, 'trashed']);
    Route::patch('categories/{id}/restore', [CategoryController::class, 'restore']);
    Route::delete('categories/{id}/force-delete', [CategoryController::class, 'forceDelete']);

    Route::apiResource('categories', CategoryController::class);

});
