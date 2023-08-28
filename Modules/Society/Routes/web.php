<?php

use Illuminate\Support\Facades\Route;
use Modules\Society\Http\Controllers\SocietyController;

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

Route::prefix('admin/society')->group(function () {
    Route::get('/', [SocietyController::class, 'index'])->name("society.list")->middleware("auth");
    Route::get('/view', [SocietyController::class, 'view_societies'])->name("societies.view")->middleware("auth");
    Route::get('/view/{id}', [SocietyController::class, 'view_society'])->name("society.view")->middleware("auth");
    
    Route::get('/create', [SocietyController::class, 'create'])->name("create.society")->middleware("auth");
    Route::post('/create/store', [SocietyController::class, "store"])->name("store.society")->middleware("auth");
    Route::get('/edit/{id}', [SocietyController::class, "edit"])->name("edit.society")->middleware("auth");
    Route::put('/edit/update/{id}', [SocietyController::class, "update"])->name("update.society")->middleware("auth");
    
    Route::post('/destroy/{id}', [SocietyController::class, "destroy"])->name("destroy.society")->middleware("auth");
    
    Route::post('/view/{sid}/member/destroy/{mid}', [SocietyController::class, "member_destroy"])->name("destroy.society.member")->middleware("auth");
    
    Route::get('/view/{id}/createform', [SocietyController::class, "createform"])->name('society.createform')->middleware("auth");
    Route::post('/view/storeformdata', [SocietyController::class, "storeformdata"])->name('society.storeformdata')->middleware("auth");
    Route::post('/view/{sid}/form/destroy/{fid}', [SocietyController::class, "form_destroy"])->name("destroy.society.form")->middleware("auth");
    Route::get('/view/{sid}/form/view/{fid}', [SocietyController::class, 'view_society_form'])->name("view.society.form")->middleware("auth");
    Route::post('/view/{sid}/form/active/{fid}', [SocietyController::class, 'form_active'])->name("society.form.active")->middleware("auth");
    Route::post('/view/submitformdata', [SocietyController::class, "submit_form_data"])->name('society.submit.formdata')->middleware("auth");
    
    Route::get('/registrationforms', [SocietyController::class, 'view_society_registrationforms'])->name("view.society.registrationforms")->middleware("auth");
    Route::post('/view/{sid}/formresponse/destroy/{fid}', [SocietyController::class, "form_response_destroy"])->name("destroy.society.form.response")->middleware("auth");
    Route::get('/view/{sid}/formresponse/view/{fid}', [SocietyController::class, 'view_society_form_response'])->name("view.society.form.response")->middleware("auth");
    
    Route::post('/view/addmember', [SocietyController::class, "add_member_to_society"])->name('society.add.member')->middleware("auth");
    
});
// Discussions
Route::get('admin/discussions', [SocietyController::class, 'societies_discussions'])->name("societies.discussions")->middleware("auth");
Route::get('admin/discussions/{sid}', [SocietyController::class, 'society_discussions'])->name("society.discussions")->middleware("auth");

Route::post('admin/save-discussions', [SocietyController::class, "saveDiscussions"])->name("admin.save.discussions")->middleware('auth');
Route::get('admin/fetch-discussions', [SocietyController::class, "fetchDiscussions"])->name("admin.fetch.discussions")->middleware('auth');
