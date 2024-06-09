<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    $tasks = auth()->user()->usersTasks()->latest()->get();
    return view('dashboard', ['tasks' => $tasks]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Task routes
    Route::post('/create-task', [TasksController::class, 'create'])->name('tasks.create');
    Route::post('/tasks/edit', [TasksController::class, 'edit'])->name('tasks.edit');
    Route::delete('/tasks/{task}', [TasksController::class, 'destroy'])->name('tasks.destroy');
});

require __DIR__.'/auth.php';
