<?php

use App\Http\Controllers\CategoryItemController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterItemsController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('master-items/export', [MasterItemsController::class, 'export'])->name('master-items.export');
Route::get('/master-items', [MasterItemsController::class, 'index']);
Route::get('/master-items/search', [MasterItemsController::class, 'search']);
Route::get('/master-items/form/{method}/{id?}', [MasterItemsController::class, 'formView']);
Route::post('/master-items/form/{method}/{id?}', [MasterItemsController::class, 'formSubmit']);

Route::get('/master-items/view/{kode}', [MasterItemsController::class, 'singleView']);
Route::get('/master-items/delete/{id}', [MasterItemsController::class, 'delete']);

Route::get('/master-items/update-random-data', [MasterItemsController::class, 'updateRandomData']);

Route::get('/category-items/search', [CategoryItemController::class, 'search'])->name('category-items.search');
Route::get('/category-items/{id}/print', [CategoryItemController::class, 'print'])->name('category-items.print');
Route::resource('category-items', CategoryItemController::class)->names('category-items');
