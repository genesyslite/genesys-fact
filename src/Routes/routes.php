<?php
use \Illuminate\Support\Facades\Route;

Route::prefix('api/v1')->group(function () {
    Route::post('documents', [\GenesysLite\GenesysFact\Http\Controllers\Api\V1\DocumentController::class, 'store']);
});