<?php

use App\Http\Controllers\AdvertController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\UserController;
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

Route::get('/', [AdvertController::class, 'home'] )->name('home');

Route::get('/dashboard', [StatisticController::class, 'index'])
->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile', [ProfileController::class, 'addSkills'])->name('profile.addSkills');
    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';
Route::get('/search', [AdvertController::class, 'search'])->name('adverts.search');
Route::get('/search', [CompanyController::class, 'search'])->name('companies.search');

Route::middleware(['auth'])->group(function () {
    Route::post('/adverts/{advert}/apply', [AdvertController::class, 'apply'])->name('adverts.apply');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::resource('companies', CompanyController::class);
    Route::resource('adverts', AdvertController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('skills', SkillController::class);
});