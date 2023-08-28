<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/login', [HomeController::class, 'login_screen'])->name("login.screen");
Route::post('/authenticate', [HomeController::class, "login"])->name("login");
Route::post('/signout', [HomeController::class, 'signout'])->name("signout");

// Admin
Route::prefix('admin')->group(function () {
    Route::get('/', [HomeController::class, "dashboard"])->name("dashboard")->middleware('auth');
});

// // Staff
// Route::prefix('staff')->group(function () {
//     Route::get('/', [HomeController::class, "staff_dashboard"])->name("staff.dashboard")->middleware('auth');
// });

// Student
Route::get('/', [HomeController::class, "student_dashboard"])->name("student.dashboard")->middleware('auth');
Route::get('/society/{id}', [HomeController::class, "view_society"])->name("student.view.society")->middleware('auth');
Route::post('/save-discussions', [HomeController::class, "saveDiscussions"])->name("save.discussions")->middleware('auth');
Route::get('/fetch-discussions', [HomeController::class, "fetchDiscussions"])->name("fetch.discussions")->middleware('auth');
