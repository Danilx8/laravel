<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/articles/', [ArticleController::class, 'retrieve']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/articles/create', [ArticleController::class, 'create']);
    Route::put('/articles/edit/{id}', [ArticleController::class, 'update']);
    Route::delete('/articles/delete/{id}', [ArticleController::class, 'delete']);
});

Route::get('/articles/comments/{id}', [CommentController::class, 'retrieve'])->middleware('path');
Route::post('/articles/comments/create/', [CommentController::class, 'create']);
Route::put('/articles/comments/edit/{id}', [CommentController::class, 'update']);
Route::delete('/articles/comments/delete/{id}', [CommentController::class, 'delete']);

Route::post('register', [AuthController::class, 'register']);
Route::post('/authenticate', [AuthController::class, 'authenticate']);
Route::get('/logout', [AuthController::class, 'logout']);
