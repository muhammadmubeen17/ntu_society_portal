<?php

use Illuminate\Support\Facades\Route;
use Modules\Staff\Http\Controllers\StaffController;

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

Route::prefix('admin/staff')->group(function () {
    Route::get('/', [StaffController::class, 'index'])->name("staff.list")->middleware("auth");

    Route::get('/create', [StaffController::class, 'create'])->name("create.staff")->middleware("auth");
    Route::post('/create/store', [StaffController::class, "store"])->name("store.staff")->middleware("auth");
    Route::get('/edit/{id}', [StaffController::class, "edit"])->name("edit.staff")->middleware("auth");
    Route::post('/edit/update/{id}', [StaffController::class, "update"])->name("update.staff")->middleware("auth");

    Route::post('/destroy/{id}', [StaffController::class, "destroy"])->name("destroy.staff")->middleware("auth");
});
