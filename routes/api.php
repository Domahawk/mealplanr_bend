<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserWeekMealPlanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('/users', [UserController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/meals', [MealController::class, 'index']);
    Route::post('/meals', [MealController::class, 'store']);
    Route::get('/meals/{meal}', [MealController::class, 'show']);
    Route::get('/ingredients', [IngredientController::class, 'index']);
    Route::post('/ingredients', [IngredientController::class, 'store']);
    Route::get('/ingredients/{ingredient}', [IngredientController::class, 'show']);
    Route::get('/me', fn () => Auth::user());
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user-meal-plan', [UserWeekMealPlanController::class, 'index']);
    Route::post('/user-meal-plan', [UserWeekMealPlanController::class, 'store']);
    Route::put('/user-meal-plan/{userWeekMealPlan}', [UserWeekMealPlanController::class, 'update']);
    Route::delete('/user-meal-plan/{userWeekMealPlan}', [UserWeekMealPlanController::class, 'destroy']);
});
