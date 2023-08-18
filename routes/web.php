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
Route::get('/alluser', [App\Http\Controllers\HomeController::class, 'alluser'])->name('alluser');
Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
Route::get('/imported', [App\Http\Controllers\ImportController::class, 'index'])->name('imported');
Route::post('/imported/addtype', [App\Http\Controllers\ImportController::class, 'addType']);
Route::get('/userProfile/{id}',[App\Http\Controllers\HomeController::class,'userProfile']);

// manage User
Route::get('/users/create', [App\Http\Controllers\HomeController::class, 'createUser'])->name('users.create');
Route::post('/users/store', [App\Http\Controllers\HomeController::class, 'storeUser'])->name('users.store');
Route::post('/users/update', [App\Http\Controllers\HomeController::class, 'updateUser']);


// change password
Route::get('/change-password/{id}', [App\Http\Controllers\ChangePasswordController::class,'showChangePasswordForm'])->name('changepassword');
Route::post('/change-password/update/{id}', [App\Http\Controllers\ChangePasswordController::class,'changePassword'])->name('updatepassword');

// register new user
// Route::get('/register2', [App\Http\Controllers\HomeController::class, 'register'])->name('register');

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
Route::get('/tables/imported', [App\Http\Controllers\ImportController::class, 'imported'])->name('importedTable');
Route::get('/tables/verify', [App\Http\Controllers\TablesController::class, 'verifyDoc'])->name('verifyDoc');

Route::post('/table/form/verify', [App\Http\Controllers\TablesController::class, 'setVerify']);


// Edit & export form
Route::get('/form/editwi/{id}',[App\Http\Controllers\FormController::class,'editFormwi']);
Route::get('/form/downloadwi/{dorv}/{id}',[App\Http\Controllers\FormController::class,'downloadFormwi']);

Route::get('/form/editsop/{id}',[App\Http\Controllers\FormController::class,'editFormsop']);
Route::get('/form/downloadsop/{dorv}/{id}',[App\Http\Controllers\FormController::class,'downloadFormsop']);

Route::get('/form/editproj/{id}',[App\Http\Controllers\FormController::class,'editFormproj']);
Route::get('/form/downloadproj/{dorv}/{id}',[App\Http\Controllers\FormController::class,'downloadFormproj']);

Route::get('/form/editpol/{id}',[App\Http\Controllers\FormController::class,'editFormpol']);
Route::get('/form/downloadpol/{dorv}/{id}',[App\Http\Controllers\FormController::class,'downloadFormpol']);

Route::get('/form/editmou/{id}',[App\Http\Controllers\FormController::class,'editFormmou']);
Route::get('/form/downloadmou/{dorv}/{id}',[App\Http\Controllers\FormController::class,'downloadFormmou']);

Route::get('/form/editanno/{id}',[App\Http\Controllers\FormController::class,'editFormanno']);
Route::get('/form/downloadanno/{dorv}/{id}',[App\Http\Controllers\FormController::class,'downloadFormanno']);

Route::get('/export/table/{type}',[App\Http\Controllers\TablesController::class,'exTable']);


// Update form
Route::post('/form/update', [App\Http\Controllers\FormController::class, 'update'])->name('update');

// view form
Route::get('/form/viewwi/{id}',[App\Http\Controllers\TablesController::class,'viewwi']);
Route::get('/form/viewsop/{id}',[App\Http\Controllers\TablesController::class,'viewsop']);
Route::get('/form/viewpolicy/{id}',[App\Http\Controllers\TablesController::class,'viewpolicy']);
Route::get('/form/viewproj/{id}',[App\Http\Controllers\TablesController::class,'viewproj']);
Route::get('/form/viewanno/{id}',[App\Http\Controllers\TablesController::class,'viewanno']);
Route::get('/form/viewmou/{id}',[App\Http\Controllers\TablesController::class,'viewmou']);

// Store Imported Doc
Route::post('/form/import/store',[App\Http\Controllers\ImportController::class,'storeImported'])->name('storeImported');

Route::post('/form/import/upStatus',[App\Http\Controllers\ImportController::class,'updateStatus']);
