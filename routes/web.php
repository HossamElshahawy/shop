<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    route::get('index',[\App\Http\Controllers\Dashboard\IndexController::class,'index'])->name('index.dashboard');
    route::resource('permission',\App\Http\Controllers\Dashboard\PermissionController::class);
    route::resource('role',\App\Http\Controllers\Dashboard\RoleController::class);
    route::resource('user',\App\Http\Controllers\Dashboard\UserController::class);

    // category
    route::resource('category',\App\Http\Controllers\Dashboard\CategoryController::class);

});





require __DIR__.'/auth.php';
