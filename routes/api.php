<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/files/upload', [FileController::class, 'uploadViaApi'])->name('files.upload.api');
Route::get('/files', [FileController::class, 'listFilesViaApi'])->name('files.list.api');
Route::post('/get-qr', [FileController::class, 'getqrcode'])->name('files.list.api');