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

// Route::get('/register', [App\Http\Controllers\HomeController::class, 'register'])->name('register');

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
Route::get('/tables/createPDF', [App\Http\Controllers\TablesController::class, 'createPDF'])->name('createPDF');


// Edit form
Route::get('/form/editwi/{id}',[App\Http\Controllers\FormController::class,'editFormwi']);
Route::get('/form/downloadwi/{id}',[App\Http\Controllers\FormController::class,'downloadFormwi']);

Route::get('/form/editsop/{id}',[App\Http\Controllers\FormController::class,'editFormsop']);
Route::get('/form/downloadsop/{id}',[App\Http\Controllers\FormController::class,'downloadFormsop']);

Route::get('/form/editproj/{id}',[App\Http\Controllers\FormController::class,'editFormproj']);
Route::get('/form/downloadproj/{id}',[App\Http\Controllers\FormController::class,'downloadFormproj']);

Route::get('/form/editpol/{id}',[App\Http\Controllers\FormController::class,'editFormpol']);
Route::get('/form/downloadpol/{id}',[App\Http\Controllers\FormController::class,'downloadFormpol']);

Route::get('/form/editmou/{id}',[App\Http\Controllers\FormController::class,'editFormmou']);
Route::get('/form/downloadmou/{id}',[App\Http\Controllers\FormController::class,'downloadFormmou']);

Route::get('/form/editanno/{id}',[App\Http\Controllers\FormController::class,'editFormanno']);
Route::get('/form/downloadanno/{id}',[App\Http\Controllers\FormController::class,'downloadFormanno']);


// Update form
Route::post('/form/update', [App\Http\Controllers\FormController::class, 'update'])->name('update');