<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\FileController;
use App\Http\Controllers\Api\V1\FolderController;

Route::apiResource('/folders', FolderController::class)->only([
    'store', 'show'
]);
Route::apiResource('/files', FileController::class)->except([
    'index', 'update'
]);
Route::get('files/{file:access_token}/download', [FileController::class, 'download'])->name('files.download');
Route::delete('files/{file}/force-delete', [FileController::class, 'forceDelete'])->name('files.force-delete');
Route::put('files/move', [FileController::class, 'moveFiles'])->name('files.move');
Route::get('folders/{folder}/files', [FileController::class, 'index'])->name('folders.files.index');
