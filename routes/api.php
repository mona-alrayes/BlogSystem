<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\Auth\AuthController;
use App\Http\Controllers\V1\Post\PostController;
use App\Http\Controllers\V1\Comment\CommentController;
use App\Http\Controllers\V1\Category\CategoryController;
use App\Http\Controllers\V1\SubCategory\SubCategoryController;
use App\Http\Controllers\V1\Role\RoleController;


// Authentication routes (public)
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::apiResource('posts', PostController::class);
    Route::get('/posts/{post}/comments', [CommentController::class, 'index']);
    Route::post('/posts/{post}/comments', [CommentController::class, 'store']);
    Route::put('/posts/{post}/comments/{comment}', [CommentController::class, 'update']);
    Route::get('/posts/{post}/comments/{comment}', [CommentController::class, 'show']);
    Route::delete('/posts/{post}/comments/{comment}', [CommentController::class, 'delete']);
});

Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('subcategories', SubCategoryController::class);
    Route::apiResource('roles', RoleController::class);
});

