<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ArticleController::class, 'index']);

Route::group(['middleware' => 'role:admin'], function () {
    Route::get('/articles/create', [ArticleController::class, 'createPage']);
    Route::post('/articles/create', [ArticleController::class, 'create']);
    Route::get('/articles/edit/{id}', [ArticleController::class, 'updatePage']);
    Route::put('/articles/edit/{id}', [ArticleController::class, 'update']);
    Route::get('/articles/delete/{id}', [ArticleController::class, 'deletePage']);
    Route::delete('/articles/delete/{id}', [ArticleController::class, 'delete']);
});

Route::get('/articles/comments/{id}', [CommentController::class, 'index']);
Route::get('/articles/comments/create/{id}', [CommentController::class, 'createIndex']);
Route::post('/articles/comments/create/', [CommentController::class, 'create']);
Route::get('/articles/comments/edit/{id}', [CommentController::class, 'editIndex']);
Route::put('/articles/comments/edit/{id}', [CommentController::class, 'edit']);
Route::get('/articles/comments/delete/{id}', [CommentController::class, 'deleteIndex']);
Route::delete('/articles/comments/delete/{id}', [CommentController::class, 'delete']);

Route::get('/register', [AuthController::class, 'registration']);
Route::post('register', [AuthController::class, 'register']);
Route::get('/authenticate', [AuthController::class, 'authentication'])->name('login');
Route::post('/authenticate', [AuthController::class, 'authenticate']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/about', function() {
    return view('main.about');
});

Route::get('/contacts', function() {
    return view('main.contacts');
});
