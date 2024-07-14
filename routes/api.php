<?php

use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::apiResource('posts', PostController::class);
Route::apiResource('comments', CommentController::class);
