<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
    Auth::logout();
    return view('auth/login');
});

Auth::routes();
Route::get('/phpinfo', function () {
    phpinfo();
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/alluser', [App\Http\Controllers\HomeController::class, 'alluser'])->name('alluser');
Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
Route::get('/imported', [App\Http\Controllers\ImportController::class, 'index'])->name('imported');
Route::post('/imported/addtype', [App\Http\Controllers\ImportController::class, 'addType']);
Route::get('/userProfile/{id}',[App\Http\Controllers\HomeController::class,'userProfile']);
Route::post('/issue/report',[App\Http\Controllers\HomeController::class,'saveIssue']);
Route::post('/issue/report/fixed',[App\Http\Controllers\HomeController::class,'issueFixed']);

// manage User
Route::get('/users/create', [App\Http\Controllers\HomeController::class, 'createUser'])->name('users.create');
Route::post('/users/store', [App\Http\Controllers\HomeController::class, 'storeUser'])->name('users.store');
Route::post('/users/update', [App\Http\Controllers\HomeController::class, 'updateUser']);

// manage data
Route::get('/management', [App\Http\Controllers\HomeController::class, 'management'])->name('management');
Route::post('permission/add', [App\Http\Controllers\HomeController::class, 'addPermis']);
Route::post('permission/del', [App\Http\Controllers\HomeController::class, 'delPermis']);
Route::post('role/add', [App\Http\Controllers\HomeController::class, 'addRole']);

Route::post('agn/add', [App\Http\Controllers\HomeController::class, 'addAgn']);
Route::post('agn/del', [App\Http\Controllers\HomeController::class, 'delAgn']);

Route::post('brn/add', [App\Http\Controllers\HomeController::class, 'addBrn']);
Route::post('brn/del', [App\Http\Controllers\HomeController::class, 'delBrn']);

Route::post('dpm/add', [App\Http\Controllers\HomeController::class, 'addDpm']);
Route::post('dpm/del', [App\Http\Controllers\HomeController::class, 'delDpm']);

Route::post('role/del', [App\Http\Controllers\HomeController::class, 'delRole']);
Route::get('/issue/report', [App\Http\Controllers\HomeController::class, 'issueReport'])->name('issue-report');

Route::post('type/del', [App\Http\Controllers\HomeController::class, 'delType']);


// change password
Route::get('/change-password/{id}', [App\Http\Controllers\ChangePasswordController::class,'showChangePasswordForm'])->name('changepassword');
Route::post('/change-password/update/{id}', [App\Http\Controllers\ChangePasswordController::class,'changePassword'])->name('updatepassword');

// register new user
// Route::get('/register2', [App\Http\Controllers\HomeController::class, 'register'])->name('register');

// Form
Route::get('/form/wiForm', [App\Http\Controllers\FormController::class, 'wiForm'])->name('wiForm');
Route::get('/form/jdForm', [App\Http\Controllers\FormController::class, 'jdForm'])->name('jdForm');
Route::get('/form/sopForm', [App\Http\Controllers\FormController::class, 'sopForm'])->name('sopForm');
Route::get('/form/policyForm', [App\Http\Controllers\FormController::class, 'policyForm'])->name('policyForm');
Route::get('/form/annoForm', [App\Http\Controllers\FormController::class, 'annoForm'])->name('annoForm');
Route::get('/form/projForm', [App\Http\Controllers\FormController::class, 'projForm'])->name('projForm');
Route::get('/form/mouForm', [App\Http\Controllers\FormController::class, 'mouForm'])->name('mouForm');
Route::post('/form/preview', [App\Http\Controllers\FormController::class, 'preview'])->name('preview');
Route::get('/form/checklist', [App\Http\Controllers\FormController::class, 'checkForm'])->name('checkForm');
Route::get('/form/costs', [App\Http\Controllers\FormController::class, 'costForm'])->name('costForm');
Route::get('/form/course', [App\Http\Controllers\FormController::class, 'courseForm'])->name('courseForm');
Route::get('/form/media', [App\Http\Controllers\FormController::class, 'mediaForm'])->name('mediaForm');


// Table
Route::get('/tables/wiTable', [App\Http\Controllers\TablesController::class, 'wiTable'])->name('wiTable');
Route::get('/tables/contract-table', [App\Http\Controllers\TablesController::class, 'contTable'])->name('contTable');
Route::get('/tables/jdTable', [App\Http\Controllers\TablesController::class, 'jdTable'])->name('jdTable');
Route::get('/tables/sopTable', [App\Http\Controllers\TablesController::class, 'sopTable'])->name('sopTable');
Route::get('/tables/policyTable', [App\Http\Controllers\TablesController::class, 'policyTable'])->name('policyTable');
Route::get('/tables/annoTable', [App\Http\Controllers\TablesController::class, 'annoTable'])->name('annoTable');
Route::get('/tables/projTable', [App\Http\Controllers\TablesController::class, 'projTable'])->name('projTable');
Route::get('/tables/mouTable', [App\Http\Controllers\TablesController::class, 'mouTable'])->name('mouTable');
Route::get('/tables/createPDF', [App\Http\Controllers\TablesController::class, 'createPDF'])->name('createPDF');
Route::get('/tables/imported', [App\Http\Controllers\ImportController::class, 'imported'])->name('importedTable');
Route::get('/tables/verify', [App\Http\Controllers\TablesController::class, 'verifyDoc'])->name('verifyDoc');
Route::get('/tables/checkTable', [App\Http\Controllers\TablesController::class, 'checkTable'])->name('checkTable');
Route::get('/tables/costTable', [App\Http\Controllers\TablesController::class, 'costTable'])->name('costTable');
Route::get('/tables/courseTable', [App\Http\Controllers\TablesController::class, 'courseTable'])->name('courseTable');
Route::get('/tables/mediaTable', [App\Http\Controllers\TablesController::class, 'mediaTable'])->name('mediaTable');

Route::post('/table/form/verify', [App\Http\Controllers\TablesController::class, 'setVerify']);
Route::post('/table/form/addTeam', [App\Http\Controllers\TablesController::class, 'addTeam']);
Route::post('/table/form/clearTeam', [App\Http\Controllers\TablesController::class, 'clearTeam']);
Route::post('/table/form/addShare', [App\Http\Controllers\TablesController::class, 'addShare']);
Route::post('/table/form/clearShare', [App\Http\Controllers\TablesController::class, 'clearShare']);
Route::post('/table/uploadFile', [App\Http\Controllers\TablesController::class, 'uploadFile']);
Route::post('/table/deleteFile', [App\Http\Controllers\TablesController::class, 'deleteFile']);


// Edit & export form
Route::get('/form/editwi/{id}',[App\Http\Controllers\FormController::class,'editFormwi']);
Route::get('/form/downloadwi/{dorv}/{id}',[App\Http\Controllers\FormController::class,'downloadFormwi'])->withoutMiddleware('auth');

Route::get('/form/editsop/{id}',[App\Http\Controllers\FormController::class,'editFormsop']);
Route::get('/form/downloadsop/{dorv}/{id}',[App\Http\Controllers\FormController::class,'downloadFormsop'])->withoutMiddleware('auth');

Route::get('/form/editjd/{id}',[App\Http\Controllers\FormController::class,'editFormjd']);
Route::get('/form/downloadjd/{dorv}/{id}',[App\Http\Controllers\FormController::class,'downloadFormjd'])->withoutMiddleware('auth');

Route::get('/form/editproj/{id}',[App\Http\Controllers\FormController::class,'editFormproj']);
Route::get('/form/downloadproj/{dorv}/{id}',[App\Http\Controllers\FormController::class,'downloadFormproj'])->withoutMiddleware('auth');

Route::get('/form/editpol/{id}',[App\Http\Controllers\FormController::class,'editFormpol']);
Route::get('/form/downloadpol/{dorv}/{id}',[App\Http\Controllers\FormController::class,'downloadFormpol'])->withoutMiddleware('auth');

Route::get('/form/editmou/{id}',[App\Http\Controllers\FormController::class,'editFormmou']);
Route::get('/form/downloadmou/{dorv}/{id}',[App\Http\Controllers\FormController::class,'downloadFormmou'])->withoutMiddleware('auth');

Route::get('/form/editanno/{id}',[App\Http\Controllers\FormController::class,'editFormanno']);
Route::get('/form/downloadanno/{dorv}/{id}',[App\Http\Controllers\FormController::class,'downloadFormanno'])->withoutMiddleware('auth');

Route::get('/form/editmedia/{id}',[App\Http\Controllers\FormController::class,'editFormmedia']);
Route::get('/form/downloadmedia/{dorv}/{id}',[App\Http\Controllers\FormController::class,'downloadFormmedia'])->withoutMiddleware('auth');

Route::get('/form/editcourse/{id}',[App\Http\Controllers\FormController::class,'editFormcourse']);
Route::get('/form/downloadcourse/{dorv}/{id}',[App\Http\Controllers\FormController::class,'downloadFormcourse'])->withoutMiddleware('auth');

Route::get('/form/editcheck/{id}',[App\Http\Controllers\FormController::class,'editFormcheck']);
Route::get('/form/downloadcheck/{dorv}/{id}',[App\Http\Controllers\FormController::class,'downloadFormcheck'])->withoutMiddleware('auth');

Route::get('/form/editcost/{id}',[App\Http\Controllers\FormController::class,'editFormcost']);
Route::get('/form/downloadcost/{dorv}/{id}',[App\Http\Controllers\FormController::class,'downloadFormcost'])->withoutMiddleware('auth');

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
Route::post('/saveSubtype',[App\Http\Controllers\TablesController::class,'saveSubtype']);

// Contact
Route::get('/contract',[App\Http\Controllers\HomeController::class,'contract'])->name('contract');
Route::get('/contract/edit/{cid}',[App\Http\Controllers\HomeController::class,'editContract'])->name('edit-contract');
Route::get('/contract/detail/{cid}',[App\Http\Controllers\ContractController::class,'contractDetail'])->name('contract-detail');
Route::post('/contract/update/{cid}',[App\Http\Controllers\ContractController::class,'updateContract'])->name('update-contract');
Route::post('/contract/store',[App\Http\Controllers\ContractController::class,'storeContract'])->name('contract-store');
Route::get('/contract/calendar',[App\Http\Controllers\ContractController::class,'contractCalendar'])->name('contract-calendar');
Route::post('/contract/projcode/add',[App\Http\Controllers\ContractController::class,'addProjCode'])->name('add-projcode');
Route::post('/contract/{cid}/uploadFile', [App\Http\Controllers\ContractController::class, 'uploadFile'])->name('cont-savefile');
Route::get('/contract/{cid}/deleteFile/{fid}', [App\Http\Controllers\ContractController::class, 'deleteFile'])->name('delContFile');
Route::get('/contract/{cid}/deleteFile2/{fname}', [App\Http\Controllers\ContractController::class, 'deleteFile2'])->name('delContFile2');

// Filepond
Route::post('/contract/file-upload',[App\Http\Controllers\ContractController::class,'filepondUpload']);
Route::delete('/contract/file-delete',[App\Http\Controllers\ContractController::class,'filepondDelete']);
