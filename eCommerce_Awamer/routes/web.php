<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\AuthController;

//seller & customer
Route::get('/',[HomeController::class,'homePage'])->name('home_page');

//just seller
Route::get('/add-item',[ItemsController::class,'addItem']);
Route::post('/add-item',[ItemsController::class,'addItemPost'])->name('add_item');
Route::get('/my-items',[ItemsController::class,'myItems']);

//just customer
//add to cart
Route::post('/',[ItemsController::class,'addToCart'])->name('addToCart');
//view cart
Route::get('/view-cart',[ItemsController::class,'viewCart']);
//view item
Route::get('/view-item/{id}',[ItemsController::class,'viewItem']);
//insert order
Route::post('/view-cart',[ItemsController::class,'insertOrder'])->name('insertOrder');
//just seller
Route::get('/view-order',[ItemsController::class,'viewOrder']);
Route::post('/view-order',[ItemsController::class,'updateOrder'])->name('updateOrder');
//seller & customer
Route::get('/seller-page/{id}',[ItemsController::class,'sellerPage']);

//login
Route::get('/login',[AuthController::class,'login']);
Route::post('/login',[AuthController::class,'loginPost'])->name('login');
//register
Route::get('/register',[AuthController::class,'register']);
Route::post('/register',[AuthController::class,'registerPost'])->name('register');
//verify
Route::get('/verify',[AuthController::class,'verifyEmail']);
//logout
Route::get('/logout',[AuthController::class,'logout'])->name('logout');
