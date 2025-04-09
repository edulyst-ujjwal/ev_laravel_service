<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::middleware('auth')->group(function () {
    Route::resource('files', FileController::class);
    Route::get('/get-qr', [App\Http\Controllers\FileController::class, 'generateQr'])->name('genQr');
    Route::post('/get-qr-save', [App\Http\Controllers\FileController::class, 'genQrsave'])->name('genQrsave');

});
