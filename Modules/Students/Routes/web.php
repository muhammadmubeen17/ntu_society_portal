<?php

use Illuminate\Support\Facades\Route;
use Modules\Students\Http\Controllers\StudentsController;

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

Route::prefix('admin/students')->group(function () {
    Route::get('/', [StudentsController::class, 'index'])->name("students.list")->middleware("auth");

    Route::get('/create', [StudentsController::class, 'create'])->name("create.student")->middleware("auth");
    Route::post('/create/store', [StudentsController::class, "store"])->name("store.student")->middleware("auth");
    Route::get('/edit/{id}', [StudentsController::class, "edit"])->name("edit.student")->middleware("auth");
    Route::post('/edit/update/{id}', [StudentsController::class, "update"])->name("update.student")->middleware("auth");

    Route::post('/destroy/{id}', [StudentsController::class, "destroy"])->name("destroy.student")->middleware("auth");
});
