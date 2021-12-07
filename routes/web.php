<?php

use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\GeneralFunctionsController;
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
Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return view('home');
    });

    Route::post('/search-user', [GeneralFunctionsController::class,'searchUser'])->name('search-user');


    Route::prefix('/admin')->name('admin.')->group(function () {
        Route::prefix('/task')->middleware(['verified'])->name('task.')->group(function () {
            Route::get('/', [TaskController::class,'index'])->name('all');
            Route::get('/create', [TaskController::class,'createView'])->name('create-view');
            Route::post('/store', [TaskController::class,'store'])->name('store');
        });
    });
});
