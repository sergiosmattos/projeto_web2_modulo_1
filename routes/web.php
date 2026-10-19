<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckIsLogged;
use App\Http\Middleware\CheckIsNotLogged;
use App\Http\Middleware\CheckIsAdmin;

Route::middleware([CheckIsLogged::class])->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('home_page');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/history', [MainController::class, 'history'])->name('history');

    Route::get('/produto={id}', [ProdutoController::class, 'viewProduto'])->name('view_produto');
});

Route::middleware([CheckIsNotLogged::class])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login_submit', [AuthController::class, 'loginSubmit'])->name('login_submit');

    Route::get('/create', [AuthController::class, 'create'])->name('create');
    Route::post('/create_submit', [AuthController::class, 'createSubmit'])->name('create_submit');
});


Route::middleware([CheckIsLogged::class, CheckIsAdmin::class])->group(function () {

    Route::get('/admin', [MainController::class, 'adminDashboard'])->name('admin_dashboard');
    Route::get('/admin/logs', [MainController::class, 'adminLogs'])->name('admin_logs');

    Route::controller(ProdutoController::class)->group(function (){

        Route::get('/produto/new', 'newProduto')->name('new_produto');
        Route::post('/produto/new_submit', 'submitNewProduto')->name('submit_new_produto');

        Route::get('/admin/delete/produto={id}', 'adminDelete')->name('admin_delete_produto');
        Route::get('/admin/restore/produto={id}', 'adminRestore')->name('admin_restore_produto');
        Route::get('/admin/force_delete/produto={id}', 'adminForceDelete')->name('admin_force_delete_produto');
        Route::get('/admin/edit/produto={id}', 'adminEdit')->name('admin_edit_produto');

        Route::post('/admin/edit_submit/produto={id}', 'adminEditSubmit')->name('admin_edit_produto_submit');
    });
    
    Route::controller(UserController::class)->group(function (){
        Route::get('/admin/delete/user={id}', 'adminDelete')->name('admin_delete_user');
        Route::get('/admin/restore/user={id}','adminRestore')->name('admin_restore_user');
        Route::get('/admin/force_delete/user={id}','adminForceDelete')->name('admin_force_delete_user');
        Route::get('/admin/edit/user={id}','adminEditUser')->name('admin_edit_user');

        Route::post('/admin/edit_submit/user={id}', 'adminEditUserSubmit')->name('admin_edit_user_submit');
    });

});
