<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostsController;
use \App\Http\Controllers\HomeController;

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


Route:: get('/',[PagesController::class, 'index']);

Route::resource('/blog', PostsController::class);
Route::get('/blog/edit/{title}', [PostsController::class, 'edit']);
Route::post('/blog/update/{title}', [PostsController::class, 'update']);
Route::post('/blog/delete/{title}', [PostsController::class, 'destroy']);


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

