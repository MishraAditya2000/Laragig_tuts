<?php

// use GuzzleHttp\Psr7\Request;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

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
//SHOW ALL LISTING
Route::get('/',[ListingController::class,'index']);

//SHOW CREATE FORM
Route::get('/listings/create',[ListingController::class,'create'])->middleware('auth');

//STORE LISTING DATA
Route::post('/listing',[ListingController::class,'store'])->middleware('auth');


//EDIT SINGLE LISTING
Route::get('/listing/{listing}/edit',[ListingController::class,'edit'])->middleware('auth');

//UPDATE LISTING
ROUTE::put('/listings/{listing}',[ListingController::class,'update']);

//DELETE LISTING
Route::delete('/listings/{listing}',[ListingController::class,'destory']);


//Manage Listing
Route::get('/listing/manage',[ListingController::class,'manage'])->middleware('auth');

//SHOW SINGLE LISTING
Route::get('/listing/{listing}',[ListingController::class,'show']);

//SHOW REGISTER PAGE
Route::get('/register',[UserController::class,'create'])->middleware('guest');

//CREATE NEW USER
Route::post('/users',[UserController::class,'store']);

//LOG USER OUT
Route::post('/logout',[UserController::class,'logout'])->middleware('auth');

//SHOW LOGIN FORM
Route::get('/login',[UserController::class,'login'])->name('login')->middleware('guest');

//LOG IN USER
Route::post('/users/authenticate',[UserController::class,'authenticate']);
