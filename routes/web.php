<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\PageController;
use App\Http\Controllers\SupportTicketController;

use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| PÚBLICO
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'inicio'])->name('inicio');
Route::get('/herramientas-ia', [PageController::class, 'herramientas'])->name('herramientas');
Route::get('/precio', [PageController::class, 'precio'])->name('precio');
Route::get('/soporte', [PageController::class, 'soporte'])->name('soporte');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');

Route::post('/soporte', [SupportTicketController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('soporte.store');

/*
|--------------------------------------------------------------------------
| DASHBOARD (decide por rol)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function (Request $request) {
    $user = $request->user();

    if ($user && method_exists($user, 'isAdmin') && $user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('inicio');
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::post('/tools', [DashboardController::class, 'storeTool'])->name('tools.store');
        Route::put('/tools/{tool}', [DashboardController::class, 'updateTool'])->name('tools.update');
        Route::delete('/tools/{tool}', [DashboardController::class, 'destroyTool'])->name('tools.destroy');

        Route::get('/tickets', [TicketController::class, 'index'])->name('tickets');
    });
use App\Http\Controllers\ProfileController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
