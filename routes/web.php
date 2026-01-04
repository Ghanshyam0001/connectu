<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\API\AuthorregistrationController;
use App\Http\Controllers\Admin\API\AuthorrequestController;
use App\Http\Controllers\Admin\API\AuthorprofileController;
use App\Http\Controllers\Admin\API\TypesController;
use App\Http\Controllers\Admin\API\CategoryController;
use App\Http\Controllers\Admin\API\ContentController;


Route::get('/', function () {
    return view('welcome');
});

// author register
Route::get('/register', function () {
    return view('adminpaneal.authauthor.registration');
})->name('author-register');

// author forgotpassword
Route::get('/forgotpassword', function () {
    return view('adminpaneal.authauthor.forgotpassword');
})->name('author-forgotpassword');

// author resetpassword
Route::get('/resetpassword', function () {
    return view('adminpaneal.authauthor.resetpassword');
})->name('author-resetpassword');


// author login
Route::get('openautherlogin', [AuthorregistrationController::class, 'loginform'])->name('openautherlogin');


Route::middleware('auth.author')->group(function () {
    // dashboard
    Route::get('/dashboard', function () {
        return view('adminpaneal.dashboards.dashboard');
    })->name('dashboard');

    // author-request
    Route::get('/author-request', function () {
        return view('adminpaneal.dashboards.request');
    })->name('author.request');

    // active author
    Route::get('/author-active', function () {
        return view('adminpaneal.dashboards.activeauthor');
    })->name('author.active');

    // Diactive author
    Route::get('/author-diactive', function () {
        return view('adminpaneal.dashboards.diactiveauthor');
    })->name('author.diactive');

    // Author Profile
    Route::get('/author-profile', [AuthorprofileController::class, 'showauthorprofile'])
        ->name('author.authorprofile');

    //content types    
    Route::get('/types', [TypesController::class, 'showtypes'])->name('types');

    // category types    
    Route::get('/categorytypes', [CategoryController::class, 'showcategorytype'])->name('categorytypes');

    // content
    Route::get('/allcontent', [ContentController::class, 'allcontent'])->name('allcontent');

    // Add content
    // content
    Route::get('/add-content', [ContentController::class, 'addcontent'])->name('addcontent');

});
