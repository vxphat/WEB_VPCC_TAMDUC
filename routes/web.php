<?php

use App\Http\Controllers\Ajax\CommentController;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\PostCatalogueController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\UserCatalogueController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Frontend\AuthClientController;
use App\Http\Controllers\Frontend\HomeController;
use \App\Http\Controllers\Frontend\PostCatalogueController as FrontendPostCatalogueController;
use \App\Http\Controllers\Frontend\PostController as FrontendPostController;

use Illuminate\Support\Facades\Route;


/* ROUTE AJAX */
use App\Http\Controllers\Ajax\AuthController as AjaxAuthController;
use App\Http\Controllers\Ajax\DashboardController as AjaxDashboardController;
use App\Http\Controllers\Ajax\LocationController;

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

/* FRONTEND ROUTE */
Route::get('/', [HomeController::class, 'index'])->name('home.index');


Route::group(['middleware' => ['admin']], function () {

    Route::get('dashboard/index', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::group(['prefix' => 'user/catalogue'], function () {
        Route::get('index', [UserCatalogueController::class, 'index'])->name('user.catalogue.index');
        Route::get('create', [UserCatalogueController::class, 'create'])->name('user.catalogue.create');
        Route::post('store', [UserCatalogueController::class, 'store'])->name('user.catalogue.store');
        Route::get('{id}/edit', [UserCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('user.catalogue.edit');
        Route::post('{id}/update', [UserCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('user.catalogue.update');
        Route::get('{id}/delete', [UserCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('user.catalogue.delete');
        Route::delete('{id}/destroy', [UserCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('user.catalogue.destroy');
    });


    Route::group(['prefix' => 'user'], function () {
        Route::get('index', [UserController::class, 'index'])->name('user.index');
        Route::get('create', [UserController::class, 'create'])->name('user.create');
        Route::post('store', [UserController::class, 'store'])->name('user.store');
        Route::get('{id}/edit', [UserController::class, 'edit'])->where(['id' => '[0-9]+'])->name('user.edit');
        Route::post('{id}/update', [UserController::class, 'update'])->where(['id' => '[0-9]+'])->name('user.update');
        Route::get('{id}/delete', [UserController::class, 'delete'])->where(['id' => '[0-9]+'])->name('user.delete');
        Route::delete('{id}/destroy', [UserController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('user.destroy');
    });


    Route::group(['prefix' => 'post/catalogue'], function () {
        Route::get('index', [PostCatalogueController::class, 'index'])->name('post.catalogue.index');
        Route::get('create', [PostCatalogueController::class, 'create'])->name('post.catalogue.create');
        Route::post('store', [PostCatalogueController::class, 'store'])->name('post.catalogue.store');
        Route::get('{id}/edit', [PostCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('post.catalogue.edit');
        Route::post('{id}/update', [PostCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('post.catalogue.update');
        Route::get('{id}/delete', [PostCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('post.catalogue.delete');
        Route::delete('{id}/destroy', [PostCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('post.catalogue.destroy');
    });

    Route::group(['prefix' => 'post'], function () {
        Route::get('index', [PostController::class, 'index'])->name('post.index');
        Route::get('create', [PostController::class, 'create'])->name('post.create');
        Route::post('store', [PostController::class, 'store'])->name('post.store');
        Route::get('{id}/edit', [PostController::class, 'edit'])->where(['id' => '[0-9]+'])->name('post.edit');
        Route::post('{id}/update', [PostController::class, 'update'])->where(['id' => '[0-9]+'])->name('post.update');
        Route::get('{id}/delete', [PostController::class, 'delete'])->where(['id' => '[0-9]+'])->name('post.delete');
        Route::delete('{id}/destroy', [PostController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('post.destroy');
    });


    //ROUTES AJAX

    Route::get('ajax/location/getLocation', [LocationController::class, 'getLocation'])->name('ajax.location.index');
    Route::post('ajax/dashboard/changeStatus', [AjaxDashboardController::class, 'changeStatus'])->name('ajax.dashboard.changeStatus');
    Route::post('ajax/dashboard/changeStatusAll', [AjaxDashboardController::class, 'changeStatusAll'])->name('ajax.dashboard.changeStatusAll');
});

Route::get('admin', [AuthController::class, 'admin'])->name('auth.admin');
Route::get('admin/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::post('admin/login', [AuthController::class, 'login'])->name('auth.login')->middleware('login');  //Kiểm tra user_catalogue_id của người đăng nhập



Route::get('login', [AuthClientController::class, 'client'])->name('client');
Route::post('ajax/login/clientLogin', [AjaxAuthController::class, 'clientLogin'])->name('client.login');
Route::post('ajax/register/register', [AjaxAuthController::class, 'register'])->name('client.register');
Route::get('register/confirm/{token}', [AuthClientController::class, 'verifyEmail'])->name('register.confirm');
Route::get('password/reset/{token}/{email}', [AuthClientController::class, 'verifyPassword'])->name('password.reset');
Route::post('password/comfirmReset/{email}', [AuthClientController::class, 'resetPassword'])->name('password.confirmReset');
Route::post('ajax/login/confirmPassword', [AjaxAuthController::class, 'confirmPassword'])->name('client.confirmPassword');
Route::get('client/logout', [AuthClientController::class, 'logout'])->name('client.logout');


Route::post('ajax/comment/sendComment', [CommentController::class, 'send'])->name('ajax.comment.sendComment');
Route::post('ajax/comment/deleteComment', [CommentController::class, 'delete'])->name('ajax.comment.deleteComment');

Route::get('account/{name}/management', [HomeController::class, 'managerAccount'])->name('client.managerAccount');

Route::post('mail/send', [HomeController::class, 'successMail'])->name('mail.send');
Route::get('/tim-kiem', [FrontendPostController::class, 'searchResult'])->name('post.search');
Route::get('/{canonical}', [FrontendPostCatalogueController::class, 'show'])->name('category.show');
Route::get('/{catalogueCanonical}/{postCanonical}', [FrontendPostController::class, 'show'])->name('post.show');


