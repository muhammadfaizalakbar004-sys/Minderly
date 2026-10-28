
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\TeamController;

// ===============================
// MANAJEMEN TUGAS
// ===============================

Route::get('/tugas', [TugasController::class, 'index']);
Route::get('/tugas/tambah', [TugasController::class, 'create']);
Route::post('/tugas/simpan', [TugasController::class, 'store']);
Route::get('/tugas/edit/{id}', [TugasController::class, 'edit']);
Route::put('/tugas/update/{id}', [TugasController::class, 'update']);
Route::delete('/tugas/hapus/{id}', [TugasController::class, 'destroy']);

// ===============================
// KOLABORASI TIM
// ===============================

Route::get('/teams', [TeamController::class, 'index'])
    ->name('teams.index');

Route::get('/teams/create', [TeamController::class, 'create'])
    ->name('teams.create');

Route::post('/teams', [TeamController::class, 'store'])
    ->name('teams.store');
    