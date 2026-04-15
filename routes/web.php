<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CKEditorController;

Route::get('/', function () {
    // return view('welcome');
    if (auth()->check()) {
        return redirect('/posts');
    }
    return redirect('/login');
});
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::resource('posts', PostController::class);
    Route::post('/ckeditor-upload', [CKEditorController::class, 'upload'])->name('ckeditor.upload');
    Route::resource('blogs', BlogController::class);
});

