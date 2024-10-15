<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\settingsController;
use App\Http\Controllers\Dashboard\userController;
use App\Http\Middleware\checkLogin;
use App\Http\Controllers\Dashboard\categoryController;
use App\Http\Controllers\Dashboard\postsController;
use App\Http\Controllers\Website\IndexController;
use App\Http\Controllers\Website\CategoryController as WebsiteCategoryController;
use App\Http\Controllers\Website\PostController as WebsitePostController  ;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::get('/',[IndexController::class,'index'])->name('index');


Route::get('/categoriess/{category}', [WebsiteCategoryController::class, 'show'])->name('categoryy');
//Route::get('/postt/{post}', [WebsitePostController::class, 'show']);



Route::group(['prefix'=>LaravelLocalization::setLocale().'/dashboard','middleware'=>['auth',checkLogin::class]],function(){
    Route::get('/', function () {
        return view('dashboard.layouts.layout');
    });
    Route::get('/settings', [settingsController::class,'index'])->name('dashboard.settings');

    Route::post('/settings/update/{setting}', [settingsController::class,'update'] )->name('settings.update');
    Route::get('/users/all', [userController::class,'getUserDataTable'] )->name('users.all');
    Route::post('/users/delete', [userController::class,'delete'] )->name('users.delete');
    Route::resource('users',userController::class);
    Route::get('/categories/all', [categoryController::class,'getCategoryDataTable'] )->name('categories.all');
    Route::post('/categorries/delete', [categoryController::class,'delete'] )->name('categories.delete');
    Route::resource('category',categoryController::class);
    Route::get('/posts/all', [postsController::class,'getPostDataTable'] )->name('posts.all');
    Route::post('/posts/delete', [postsController::class,'delete'] )->name('posts.delete');
    Route::resource('post',postsController::class);
    
});
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
