<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cp\AuthController;
use App\Http\Controllers\Cp\PostController;
use App\Http\Controllers\Cp\RoleController;
use App\Http\Controllers\Cp\UserController;
use App\Http\Controllers\Cp\SliderController;
use App\Http\Controllers\Cp\ProfileController;
use App\Http\Controllers\Cp\SettingController;
use App\Http\Controllers\Cp\CategoryController;
use App\Http\Controllers\Cp\DashboardController;
use App\Http\Controllers\Cp\SocialMediaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/admin', function () {
    return view('cp.auth.login');
});

Route::group(['middleware' => 'auth'], function(){
    Route::view('/backup', 'laravel_backup_panel::layout');
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::group(['prefix' => 'cp'], function(){
        // role and permission module
        Route::get('role/datatables', [RoleController::class, 'getDatatable'])->name('role.datatable');
        Route::resource('roles', RoleController::class);
        // users module 
        Route::resource('users', UserController::class);
        Route::group(['prefix' => 'content'], function(){
            // sliders
            // Route::get('sliders/datatables', [SliderController::class, 'getDatatable'])->name('slider.datatable');
            Route::post('/sliders/change-order', [SliderController::class, 'changeSliderOrder'])->name('sliders.move');
            Route::resource('/sliders', SliderController::class);
            // categories
            Route::get('categories/datatables', [CategoryController::class, 'getDatatable'])->name('category.datatable');
            Route::resource('categories', CategoryController::class);
            // posts resources
            Route::get('post/datatables', [PostController::class, 'postDatatables'])->name('posts.datatable');
            Route::resource('post', PostController::class);
            
            // trash and restore (utils)
            Route::get('posts-in-trash/datatables', [PostController::class, 'postInTrashDatatables'])->name('posts-in-trash.datatable');
            Route::get('post/utils/trash', [PostController::class, 'getPostTrash'])->name('post.trash');
            Route::put('post/utils/{id}/restore', [PostController::class, 'restoreTrashedItem'])->name('post.restore');
            Route::put('post/utils/restore-all-data', [PostController::class, 'restoreAllTrashedItem'])->name('post.restore-all');
            Route::delete('post/utils/delete-permanent', [PostController::class, 'deletePermanentAllTrashedItem'])->name('post.delete-all-permanent');
            Route::delete('post/utils/{id}/delete-permanent', [PostController::class, 'deletePermanentTrashedItem'])->name('post.delete-permanent');
            // arhive and publish 
            Route::put('post/{id}/publish', [PostController::class, 'publishPost'])->name('publish.post');
            Route::put('post/{id}/archive', [PostController::class, 'archivePost'])->name('archive.post');
        });
        Route::group(['prefix' => 'settings'], function(){
            //change user profile
            Route::get('change-profile/{id}', [ProfileController::class, 'profile'])->name('user-profile');
            Route::put('change-profile/{id}', [ProfileController::class, 'changeProfile'])->name('user-profile.update');
            //change password
            Route::get('change-password/{id}', [ProfileController::class, 'password'])->name('user-password');
            Route::put('change-password/{id}', [ProfileController::class, 'changePassword'])->name('user-password.update');
            // website setting
            Route::get('site-setting', [SettingController::class, 'index'])->name('setting.index');
            Route::put('site-setting', [SettingController::class, 'updateSetting'])->name('setting.update');
        });
    });
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
