<?php

use App\Http\Controllers\Admin\HomeController;
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

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/managerview', [HomeController::class, 'managerview'])->name('managerview');
Route::get('/managerform/{user?}', [HomeController::class, 'managerform'])->name('managerform');
Route::post('/managersave', [HomeController::class, 'managersave'])->name('managersave');
Route::get('/managerdelete/{user}', [HomeController::class, 'managerdelete'])->name('managerdelete');
Route::get('/managerrestore/{user}', [HomeController::class, 'managerrestore'])->name('managerrestore');
