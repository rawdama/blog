<?php
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Middleware\CheckLanguageApi;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\CategoryAdminController;

Route::get('/', function (Request $request) {
    return 123;
});



Route::middleware([CheckLanguageApi::class])->group(function () {
    Route::get('settings', [SettingController::class, 'index'])->middleware(['auth:sanctum']);
    Route::get('nav-categories', [CategoryController::class, 'navbarCategories']);
    Route::get('index-page-categories', [CategoryController::class, 'indexPageCategoriesWithPosts']);

    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{id}', [CategoryController::class, 'show']);

    Route::apiResource('posts',PostController::class)->except(['update','store','destroy']);

    Route::get('login', [LoginController::class, 'login']);
    Route::get('logout', [LoginController::class, 'logout'])->middleware(['auth:sanctum']);

    Route::apiResource('CategoryAdmin',CategoryAdminController::class)->except(['index','show'])->middleware(['auth:sanctum']);


});