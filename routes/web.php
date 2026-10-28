
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KuesionerController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamChatController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\AutoTeamController;

/*
|--------------------------------------------------------------------------
| Halaman Utama
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| Login dan Register
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.process');
});

/*
|--------------------------------------------------------------------------
| Halaman yang Memerlukan Login
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // Kuesioner profil pengguna
    Route::get('/kuesioner', [KuesionerController::class, 'create'])
        ->name('kuesioner.create');

    Route::post('/kuesioner', [KuesionerController::class, 'store'])
        ->name('kuesioner.store');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Manajemen tugas
    Route::prefix('tugas')->name('tugas.')->group(function () {
        Route::get('/', [TugasController::class, 'index'])
            ->name('index');

        Route::get('/tambah', [TugasController::class, 'create'])
            ->name('create');

        Route::post('/simpan', [TugasController::class, 'store'])
            ->name('store');

        Route::get('/edit/{id}', [TugasController::class, 'edit'])
            ->name('edit');

        Route::put('/update/{id}', [TugasController::class, 'update'])
            ->name('update');

        Route::delete('/hapus/{id}', [TugasController::class, 'destroy'])
            ->name('destroy');
    });

    // Kolaborasi tim
    Route::get('/teams', [TeamController::class, 'index'])
        ->name('teams.index');

    Route::get('/teams/create', [TeamController::class, 'create'])
        ->name('teams.create');

    Route::post('/teams', [TeamController::class, 'store'])
        ->name('teams.store');

Route::get('/teams/{team}', [TeamController::class, 'show'])
    ->name('teams.show');

Route::post('/teams/{team}/members', [TeamController::class, 'addMember'])
    ->name('teams.members.store');

Route::post('/teams/{team}/invite', [TeamController::class, 'generateInvite'])
    ->name('teams.invite.generate');

Route::get('/teams/invite/{token}', [TeamController::class, 'joinByInvite'])
    ->name('teams.invite.join');

Route::get('/teams/{team}/chat', [TeamChatController::class, 'index'])
    ->name('teams.chat.index');

Route::post('/teams/{team}/chat', [TeamChatController::class, 'store'])
    ->name('teams.chat.store');

    // Route khusus admin untuk pengelolaan proyek
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/proyek', [ProyekController::class, 'index'])
            ->name('proyek.index');

        Route::get('/proyek/tambah', [ProyekController::class, 'create'])
            ->name('proyek.create');

        Route::post('/proyek', [ProyekController::class, 'store'])
            ->name('proyek.store');

        Route::get('/proyek/{proyek}', [ProyekController::class, 'show'])
            ->name('proyek.show');

        Route::post('/bagi-tim-otomatis', [AutoTeamController::class, 'assign'])
            ->name('tim.assign');
    });



});
