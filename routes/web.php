<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/upload-file', [\App\Http\Controllers\FileUploaderController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('file.uploader');

Route::get('/get-file', [\App\Http\Controllers\GetFileController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('file.get');

Route::get('/dashboard', function () {
    $isRunJob = \Illuminate\Support\Facades\Redis::get('current_row_id') ? true : false;
    return view('dashboard', ['jobIsRunning' => $isRunJob]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
