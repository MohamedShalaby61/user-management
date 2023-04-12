<?php

use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
    return view('welcome');
});

Route::resource('users', UserController::class);
Route::post('users/{user}/roles/{role}', [UserController::class, 'assignRole'])->name('users.roles.assign');

Route::get('/ss', function () {
    return view('layouts.app');
});

Route::get('roles', [RoleController::class, 'edit'])->name('users.roles.index');
Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update');

Route::get('categories', function(){
    return view('categories', [
        'title' => 'categories'
    ]);
})->name('categories.index');

Route::get('sliders', function(){
    return view('sliders', [
        'title' => 'sliders'
    ]);
})->name('sliders.index');

Route::get('dashboard', function(){
    return view('dashboard', [
        'title' => 'dashboard'
    ]);
})->name('dashboard');
