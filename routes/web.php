<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Models\category;
use GuzzleHttp\Middleware;
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

// Route::prefix('cms/admin')->group(function(){

//     Route::view('/', 'cms.index');

//      Route::get('/users', [UserController::class, 'index'])->name('users.index');

//     Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
//     Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

//     Route::post('/users', [UserController::class, 'store'])->name('users.store');

//     Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
//     Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');

//     Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
// });

Route::prefix('cms/admin')->middleware('guest:admin')->group(function(){
    Route::get('/login' , [AuthController::class , 'showLogin'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::prefix('cms/admin')->middleware('auth:admin')->group(function() {
    Route::view('/', 'cms.index');
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::get('logout', [AuthController::class , 'logout'])->name('auth.logout');
});
