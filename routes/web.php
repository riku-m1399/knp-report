<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PromotersController;
use App\Http\Controllers\Admin\PlacesController;
use App\Http\Controllers\Admin\ReportsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
    Route::get('/panel', [HomeController::class, 'panel'])->name('panel');

    // Report
    Route::group(['prefix' => 'report', 'as' => 'report.'], function(){
        Route::get('/create', [ReportController::class, 'create'])->name('create');
        Route::post('/store', [ReportController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ReportController::class, 'edit'])->name('edit');
        Route::patch('/update/{id}', [ReportController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [ReportController::class, 'destroy'])->name('destroy');
    });

    // Admin
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function(){
        Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
        // Admin promoters
        Route::get('/setting/promoters', [PromotersController::class, 'index'])->name('setting.promoters');
        Route::patch('/setting/promoters/update/{id}', [PromotersController::class, 'update'])->name('setting.promoters.update');
        Route::get('/setting/places', [PlacesController::class, 'index'])->name('setting.places');
        Route::post('/setting/places/store', [PlacesController::class, 'store'])->name('setting.places.store');
        Route::patch('/setting/places/update/{id}', [PlacesController::class, 'update'])->name('setting.places.update');
        Route::delete('/setting/places/destroy/{id}', [PlacesController::class, 'destroy'])->name('setting.places.destroy');
        Route::get('/setting/reports', [ReportsController::class, 'index'])->name('setting.reports');
    });
});

