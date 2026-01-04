<?php

use App\Http\Controllers\Admin\API\AuthorregistrationController;
use App\Http\Controllers\Admin\API\AuthorrequestController;
use App\Http\Controllers\Admin\API\AuthorprofileController;
use App\Http\Controllers\Admin\API\TypesController;
use App\Http\Controllers\Admin\API\CategoryController;
use App\Http\Controllers\Admin\API\ContentController;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// register author
Route::post('register', [AuthorregistrationController::class, 'register']);

// forgotauthorpassword
Route::post('forgotauthorpassword', [AuthorregistrationController::class, 'forgotauthorpassword']);

// resetpassword
Route::post('/resetauthorpassword', [AuthorregistrationController::class, 'resetauthorpassword']);

// author Request Approved
Route::post('/requestapproved/{id}', [AuthorrequestController::class, 'authorrequestapproved']);

// author Request Reject
Route::post('/requestreject/{id}', [AuthorrequestController::class, 'authorrequestreject']);

// approve or reject author request
Route::get('/approveorreject', [AuthorrequestController::class, 'approveorreject'])->name('approveorreject');

// show Active Author
Route::get('/showactive', [AuthorrequestController::class, 'showactive'])->name('showactive');

// show Diactive Author
Route::get('/showdiactive', [AuthorrequestController::class, 'showdiactive'])->name('showdiactive');

// Active Author
Route::post('/activeauthor/{id}', [AuthorrequestController::class, 'activeauthor'])->name('activeauthor');

// Diactive Author
Route::post('/diactiveauthor/{id}', [AuthorrequestController::class, 'diactiveauthor'])->name('diactiveauthor');

// Change Author Password
Route::put('/changePassword/{id}', [AuthorprofileController::class, 'changePassword']);

// change Author Image
Route::get('/changeautherimage/{id}', [AuthorprofileController::class, 'changeautherimage'])
  ->name('changeautherimage');

// Update author image
Route::match(['post', 'put'], '/updateauthorimage/{id}', [AuthorprofileController::class, 'updateauthorimage'])
  ->name('updateauthorimage');


// addtype
Route::post('/addtype', [TypesController::class, 'addtype']);
        
// showtype
Route::get('/changetype/{id}', [TypesController::class, 'showtyp']);

// updatetype
Route::match(['post', 'put'], '/updatetyp/{id}', [TypesController::class, 'updatetypes'])
  ->name('updatetyp');

// delete type
Route::delete('/deletetype/{id}', [TypesController::class, 'destroy']);



// add category type
Route::post('/addctype', [CategoryController::class, 'addctype']);
        
// show category type
Route::get('/changectype/{id}', [CategoryController::class, 'showctyp']);

// update category type
Route::match(['post', 'put'], '/updatectyp/{id}', [CategoryController::class, 'updatectypes'])
  ->name('updatectyp');

// delete category type
Route::delete('/deletectype/{id}', [CategoryController::class, 'cdestroy']);

// all content show
Route::get('/showcontents', [ContentController::class, 'showcontents']);

// add new contant
Route::post('/addnewcontent', [ContentController::class, 'addnewcontent']);

// delete contant
Route::delete('/deletecontent/{id}', [ContentController::class, 'deletecontent']);

// view single content
Route::get('/viewsingalcontent/{id}',[ContentController::class,'viewsingalcontent']);

// view singal content for update
Route::get('/singalupdatecontent/{id}',[ContentController::class,'singalupdatecontent']);


// update contant
Route::post('/updatecontent/{id}',[ContentController::class,'updatecontent']);


// login and logout
Route::middleware('web')->group(function () {

  Route::post('login', [AuthorregistrationController::class, 'login']);
  Route::post('logout', [AuthorregistrationController::class, 'logout']);
});
