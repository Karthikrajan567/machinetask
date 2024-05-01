<?php

use App\Http\Controllers\Member\HomeController;
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

Route::get('/taskupdateview', [HomeController::class, 'taskupdateview'])->name('taskupdateview');
Route::get('/updatestatus/{task}', [HomeController::class, 'updatestatus'])->name('updatestatus');
