<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\GeneralFunctionsController;

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

    Route::get('/', function () {return view('home');})->name('home');

    Route::post('/search-user', [GeneralFunctionsController::class,'searchUser'])->name('search-user');


    Route::prefix('/task')->middleware(['verified'])->name('task.')->group(function () {
        Route::get('/', [TaskController::class,'index'])->name('all');
        Route::get('/create', [TaskController::class,'createView'])->name('create-view')->middleware(['admin']);
        Route::post('/store', [TaskController::class,'store'])->name('store')->middleware(['admin']);
        Route::get('/edit/{id}', [TaskController::class,'editView'])->name('edit-view')->middleware(['admin']);
        Route::post('/update', [TaskController::class,'update'])->name('update')->middleware(['admin']);
        Route::get('/submit-view/{id}', [TaskController::class,'submitView'])->name('submit-view');
        Route::post('/submit-task', [TaskController::class,'submitTask'])->name('submit-task');
        Route::get('/review/{id}', [TaskController::class,'reviewView'])->name('review-view');
        Route::post('/submit-review', [TaskController::class,'submitReview'])->name('submit-review');
        Route::post('/download-document', [TaskController::class,'downloadDocument'])->name('download-document');

    });



    Route::prefix('/admin')->name('admin.')->group(function () {
        //users routes
        Route::prefix('/users')->name('user.')->middleware(['admin'])->group(function(){

            // get users page
            Route::get('/', [UserController::class, 'index'])->name('all');

            // get all users
            Route::get('/get', [UserController::class, 'getUser'])->name('get');

            // search users
            Route::post('/search', [UserController::class, 'searchUser'])->name('search');

            //create user
            Route::post('/create', [UserController::class,'createuser'])->name('create');

            //edit user
            Route::post('/edit', [UserController::class,'edituser'])->name('edit');

            //ban user
            Route::get('/{id}/ban', [UserController::class,'banUser'])->name('ban-user');

            //unban user
            Route::get('/{id}/unban', [UserController::class,'unbanUser'])->name('unban-user');

            //user profile page
            Route::get('/{id}', [ProfileController::class,'profile'])->name('profile');

            //user login logs
            Route::get('/{id}/login-logs', [ProfileController::class,'loginLogs'])->name('log');

        });
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
