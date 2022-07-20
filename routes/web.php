<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UploadCsvController;
use App\Models\UploadCsv;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});


Route::get('create-post', [PostController::class, 'create'])->name('post.form');
Route::post('submit-post', [PostController::class, 'store'])->name('post.submit');

Route::get('upload-file', [UploadCsvController::class, 'index'])->name('upload.file');
Route::post('submit-upload-file', [UploadCsvController::class, 'store'])->name('upload.submit');

Route::get('upload-file-store', [UploadCsvController::class, 'storeData'])->name('upload.file.store');

