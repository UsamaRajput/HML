<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ComplainController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RequestedRoomController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/admin', function () {
    return Inertia::render('Admin/Dashboard');
})->name('admin.dashboard');


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Route::resource('room', RoomController::class);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('room/{room}', [RoomController::class, 'update'])->name('room.update');
    Route::post('room/{room}/test', [RoomController::class, 'test'])->name('room.test');
    Route::get('room/{room}/activeInactive', [RoomController::class, 'activeInactive'])->name('room.activeInactive');
    Route::resource('room', RoomController::class, ['except' => ['update']]);

    Route::post('requested_room', [RequestedRoomController::class, 'requestedRoom'])->name('requested.requestedRoom');
    Route::post('approve_room', [RequestedRoomController::class, 'approveRoom'])->name('requested.approveRoom');
    Route::post('reject_room', [RequestedRoomController::class, 'rejectRoom'])->name('requested.rejectRoom');
    Route::resource('requested', RequestedRoomController::class);

    Route::get('rating/{rating}/activeInactive', [RatingController::class, 'activeInactive'])->name('rating.activeInactive');
    Route::post('rating/{rating}', [RatingController::class, 'update'])->name('rating.update');
    Route::resource('rating', RatingController::class, ['except' => ['update']]);

    Route::post('complain/{complain}', [ComplainController::class, 'complainProgress'])->name('complain.complainProgress');
    Route::resource('complain', ComplainController::class, ['except' => ['update']]);
});

require __DIR__ . '/auth.php';
