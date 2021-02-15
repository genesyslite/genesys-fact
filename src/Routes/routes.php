<?php

use \Illuminate\Support\Facades\Route;


Route::prefix('api/v1')->group(function () {
    Route::middleware(['auth:api'])->group(function () {
        Route::post('documents', [\GenesysLite\GenesysFact\Http\Controllers\Api\V1\DocumentController::class, 'store']);
    });

    Route::get('downloads/{model}/{type}/{external_id}/{format?}', [\GenesysLite\GenesysFact\Http\Controllers\DownloadController::class, 'downloadExternal'])->name('v1.download.external_id');
});
