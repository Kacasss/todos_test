<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoItemController;
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
});

require __DIR__.'/auth.php';

// Route::resource('todo', TodoItemController::class);
// ログイン中のみ、TODOリストへ遷移可
Route::middleware('auth')->group(function () {
    Route::get('todo/{todo}/complete', [TodoItemController::class, 'complete'])->name('todo.complete');
    Route::resource('todo', TodoItemController::class);
});

// Route::middleware('auth')->resource('todo', TodoItemController::class);