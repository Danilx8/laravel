<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;

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
Route::get('/articles/create', [ArticleController::class, 'createPage']);
Route::post('/articles/create', [ArticleController::class, 'create']);
Route::get('/articles/edit/{id}', [ArticleController::class, 'updatePage']);
Route::put('/articles/edit/{id}', [ArticleController::class, 'update']);
Route::delete('/articles/delete/{id}', [ArticleController::class, 'delete']);

Route::get('/registration', [AuthController::class, 'create']);
Route::post('/registration', [AuthController::class, 'registration']);

Route::get('/about', function() {
    return view('main.about');
});

Route::get('/contacts', function() {
    return view('main.contacts');
});
