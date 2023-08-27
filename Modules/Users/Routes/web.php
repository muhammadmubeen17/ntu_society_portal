<?php

use Illuminate\Support\Facades\Route;
use Modules\Users\Http\Controllers\UsersController;

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

Route::prefix('admin/users')->group(function () {
    Route::get('/', [UsersController::class, 'index'])->name("users.list")->middleware("auth");

    Route::get('/create', [UsersController::class, 'create'])->name("create.user")->middleware("auth");
    Route::post('/create/store', [UsersController::class, "store"])->name("store.user")->middleware("auth");
    Route::get('/edit/{id}', [UsersController::class, "edit"])->name("edit.user")->middleware("auth");
    Route::post('/edit/update/{id}', [UsersController::class, "update"])->name("update.user")->middleware("auth");

    Route::post('/destroy/{id}', [UsersController::class, "destroy"])->name("destroy.user")->middleware("auth");
});
