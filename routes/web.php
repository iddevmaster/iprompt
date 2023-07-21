<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Form
Route::get('/form/wiForm', [App\Http\Controllers\FormController::class, 'wiForm'])->name('wiForm');
Route::get('/form/sopForm', [App\Http\Controllers\FormController::class, 'sopForm'])->name('sopForm');
Route::get('/form/policyForm', [App\Http\Controllers\FormController::class, 'policyForm'])->name('policyForm');
Route::get('/form/annoForm', [App\Http\Controllers\FormController::class, 'annoForm'])->name('annoForm');
Route::get('/form/projForm', [App\Http\Controllers\FormController::class, 'projForm'])->name('projForm');
Route::get('/form/mouForm', [App\Http\Controllers\FormController::class, 'mouForm'])->name('mouForm');
Route::post('/form/preview', [App\Http\Controllers\FormController::class, 'preview'])->name('preview');

// Table
Route::get('/tables/wiTable', [App\Http\Controllers\TablesController::class, 'wiTable'])->name('wiTable');
Route::get('/tables/sopTable', [App\Http\Controllers\TablesController::class, 'sopTable'])->name('sopTable');
Route::get('/tables/policyTable', [App\Http\Controllers\TablesController::class, 'policyTable'])->name('policyTable');
Route::get('/tables/annoTable', [App\Http\Controllers\TablesController::class, 'annoTable'])->name('annoTable');
Route::get('/tables/projTable', [App\Http\Controllers\TablesController::class, 'projTable'])->name('projTable');
Route::get('/tables/mouTable', [App\Http\Controllers\TablesController::class, 'mouTable'])->name('mouTable');