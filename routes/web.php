<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\LinkController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PayoutController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\ParentsController;
use App\Http\Controllers\Admin\WebsiteController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\GeneralFunctionsController;
use App\Http\Controllers\TaskConversationController;

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

    Route::get('/', [HomeController::class,'index'])->name('home');

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
        Route::post('/search', [TaskController::class, 'searchUser'])->name('search');
        Route::post('/cancel', [TaskController::class, 'cancelTask'])->name('cancel');
        Route::get('/acknowledge/{task}', [TaskController::class, 'acknowledgeTask'])->name('acknowledge');
        Route::get('/copy/{task}', [TaskController::class, 'copyTask'])->name('copy');

        //conversations routes
        Route::prefix('/conversations')->name('conversation.')->middleware(['verified'])->group(function(){
            Route::get('/{task_id}', [TaskConversationController::class, 'index'])->name('all');
            Route::post('/store', [TaskConversationController::class,'store'])->name('store');
            Route::get('/edit/{id}', [PayoutController::class,'edit'])->name('edit-view');
            Route::get('/delete/{id}', [PayoutController::class, 'delete'])->name('delete');
            Route::post('/update', [PayoutController::class,'update'])->name('update');
            Route::post('/map-to-task', [PayoutController::class,'mapToTask'])->name('map');

        });
    });

    //notifications routes
    Route::prefix('/notifications')->name('notification.')->middleware(['verified'])->group(function(){
        Route::get('/', [NotificationsController::class, 'index'])->name('all');
        Route::get('/{log}', [NotificationsController::class,'single'])->name('single');
       
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
            Route::get('/create', [UserController::class,'createView'])->name('create-view');
            Route::post('/store', [UserController::class,'createuser'])->name('create');

            //edit user
            Route::get('/edit/{id}', [UserController::class,'editView'])->name('edit-view');
            Route::post('/update', [UserController::class,'edituser'])->name('update');

            // delete user
            Route::get('/delete/{id}', [UserController::class, 'delete'])->name('delete');

        });

        //regions routes
        Route::prefix('/regions')->name('region.')->middleware(['admin'])->group(function(){

            // get regions page
            Route::get('/', [RegionController::class, 'index'])->name('all');

            // delete regions
            Route::get('/delete/{id}', [RegionController::class, 'delete'])->name('delete');

            //create region
            Route::post('/create', [RegionController::class,'create'])->name('create');

            //edit region
            Route::post('/edit', [RegionController::class,'edit'])->name('edit');

        });

        //Currencys routes
        Route::prefix('/currencies')->name('currency.')->middleware(['admin'])->group(function(){

            // get Currencys page
            Route::get('/', [CurrencyController::class, 'index'])->name('all');

            // delete Currencys
            Route::get('/delete/{id}', [CurrencyController::class, 'delete'])->name('delete');

            //create Currency
            Route::post('/create', [CurrencyController::class,'create'])->name('create');

            //edit Currency
            Route::post('/edit', [CurrencyController::class,'edit'])->name('edit');

        });

        //parent routes
        Route::prefix('/parents')->name('parent.')->middleware(['admin'])->group(function(){

            // delete Parents
            Route::get('/delete/{id}', [ParentsController::class, 'delete'])->name('delete');

            //create Parents
            Route::post('/create', [ParentsController::class,'create'])->name('create');

            //edit Parents
            Route::post('/edit', [ParentsController::class,'edit'])->name('edit');

        });

        //websites routes
        Route::prefix('/websites')->name('website.')->middleware(['admin'])->group(function(){

            // get websites page
            Route::get('/', [WebsiteController::class, 'index'])->name('all');

            // delete websites
            Route::get('/delete/{id}', [WebsiteController::class, 'delete'])->name('delete');

            //create website
            Route::post('/create', [WebsiteController::class,'create'])->name('create');

            //edit website
            Route::post('/edit', [WebsiteController::class,'edit'])->name('edit');

        });

        //payout routes
        Route::prefix('/payouts')->name('payout.')->middleware(['admin'])->group(function(){
            Route::get('/', [PayoutController::class, 'index'])->name('all');
            Route::get('/create', [PayoutController::class, 'create'])->name('create-view');
            Route::post('/store', [PayoutController::class,'store'])->name('store');
            Route::get('/edit/{id}', [PayoutController::class,'edit'])->name('edit-view');
            Route::get('/delete/{id}', [PayoutController::class, 'delete'])->name('delete');
            Route::post('/update', [PayoutController::class,'update'])->name('update');
            Route::post('/map-to-task', [PayoutController::class,'mapToTask'])->name('map');


        });

        //link routes
        Route::prefix('/links')->name('link.')->middleware(['admin'])->group(function(){
            Route::get('/', [LinkController::class, 'index'])->name('all');
            Route::get('/create', [LinkController::class, 'create'])->name('create-view');
            Route::post('/store', [LinkController::class,'store'])->name('store');
            Route::get('/edit/{id}', [LinkController::class,'edit'])->name('edit-view');
            Route::get('/delete/{id}', [LinkController::class, 'delete'])->name('delete');
            Route::post('/update', [LinkController::class,'update'])->name('update');
            Route::post('/map-to-task', [LinkController::class,'mapToTask'])->name('map');


        });

        //settings route
        Route::prefix('/settings')->name('setting.')->middleware(['admin'])->group(function(){
            Route::get('/', [SettingsController::class, 'index'])->name('all');
            Route::post('/save', [SettingsController::class, 'save'])->name('save');
            
        });

    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
