<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Reviewer\ReviewerController;
use App\Http\Controllers\Admin\AdminClassController;
use App\Http\Controllers\MasterKelasController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AIController;

/*
|--------------------------------------------------------------------------
| 1. ROUTE PUBLIK (LANDING & SURVEY)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('landing');
})->name('landing');

// ===== SURVEY (PUBLIK / ANONIM) =====
Route::get('/survey', [SurveyController::class, 'index'])
    ->name('survey.index');

Route::post('/survey/submit', [SurveyController::class, 'store'])
    ->name('submit.survey');

Route::get('/survey/terima-kasih', function () {
    return view('survey.thankyou');
})->name('survey.thankyou');

Route::get('/survey/feedback', [SurveyController::class, 'feedback'])
    ->name('survey.feedback');


// /*
// |--------------------------------------------------------------------------
// | 2. ROUTE DASHBOARD GLOBAL (ANTI ERROR DEFAULT LARAVEL)
// |--------------------------------------------------------------------------
// | Menangkap redirect otomatis ke /dashboard
// */

Route::get('/dashboard', function () {

    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->hasRole('reviewer')) {
        return redirect()->route('reviewer.dashboard');
    }

    return redirect()->route('landing');

})->middleware('auth')->name('dashboard');


// /*
// |--------------------------------------------------------------------------
// | 3. ADMIN ROUTE (LOGIN WAJIB)
// |--------------------------------------------------------------------------
// */

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::post('/ai-summarize', [AIController::class, 'summarize'])->name('ai.summarize');

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/export', [AdminDashboardController::class, 'export'])
            ->name('export');

        Route::get('/class', [AdminClassController::class, 'index'])->name('class');

        Route::resource('admin/master-kelas', MasterKelasController::class);
    });


// /*
// |--------------------------------------------------------------------------
// | 4. REVIEWER ROUTE (LOGIN WAJIB)
// |--------------------------------------------------------------------------
// */

Route::middleware(['auth', 'role:reviewer'])
    ->prefix('reviewer')
    ->name('reviewer.')
    ->group(function () {

        Route::get('/dashboard', [ReviewerController::class, 'dashboard'])
            ->name('dashboard');
    });


/*
|--------------------------------------------------------------------------
| 5. AUTH (LOGIN / LOGOUT)
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

require __DIR__.'/auth.php';
