<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get("/user",function (Request $request){
    return $request->user();
})->middleware("auth:sanctum");
Route::apiResource('posts',PostController::class);
Route::post('/register',[AuthController::class,'register'])->name('register');
Route::post('/login',[AuthController::class,'login'])->name(   'login');
Route::post('logout',[AuthController::class,'logout'])->name( 'logout')->middleware('auth:sanctum');
