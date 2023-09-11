<?php

use App\Http\Controllers\Admin\AdminAjaxController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminBlogController;
use Illuminate\Support\Facades\Route;

Route::controller(AdminAjaxController::class)
    ->prefix('ajax-admin')
    ->group(function () {
        Route::get('change-status-item/{id}', 'changeStatusItem')->name('ajaxAdmin.changeStatusItem');
        Route::post('upload-image-temp', 'uploadImageTemp');
    });

Route::name('admin.')->group(function () {
    Route::controller(AdminAuthController::class)
        ->group(function () {
            // Authenticate
            Route::get('login', 'login')->name('login');
            Route::post('login', 'loginPost')->name('login-post');
            Route::get('register', 'register')->name('register');
            Route::get('forgot-password', 'forgotPassword')->name('forgot-password');
    });

    Route::middleware(['auth.admin'])->group(function () {
        // Users
        Route::resource('users', AdminUserController::class);

        Route::controller(AdminBlogController::class)
            ->prefix('blogs')
            ->group(function () {
                Route::get('/', 'index')->name('blogs.index');
                Route::get('/create', 'create')->name('blogs.create');
                Route::post('/store', 'store')->name('blogs.store');
                Route::get('/edit/{id}', 'edit')->name('blogs.edit');
                Route::post('/update/{id}', 'update')->name('blogs.update');
                Route::delete('/delete/{id}', 'destroy')->name('blogs.delete');
            });

        // Logout
        Route::get('logout', 'Admin\AdminAuthController@logout')->name('logout');
    });
});
