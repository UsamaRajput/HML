<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ComplainController;
use App\Http\Controllers\GeneralServicesController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RequestedRoomController;
use App\Models\GeneralServices;
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
    if (auth()->guard()->name != 'web') {
        if (auth()->user()->role == 1) {
            return redirect(route('admin.dashboard'));
        } else if (auth()->user()->role == 0) {
            return redirect(route('profile.edit'));
        }
    } else {
        return redirect(route('login'));
    }
    // return Inertia::render('Welcome', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);
});


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Route::resource('room', RoomController::class);


Route::middleware('auth')->group(function () {
Route::group(['prefix' => 'user',/* 'middleware' => 'user_auth'*/], function () {
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.edit');
        Route::post('/changeImage', [UserInfoController::class, 'changeImage'])->name('profile.changeImage');
        Route::post('/profile', [UserInfoController::class, 'updateProfile'])->name('profile.updateProfile');
        // User Room
        Route::get('/rooms', [RoomController::class, 'userRooms'])->name('user.rooms');
        Route::post('/requestRoom', [RequestedRoomController::class, 'requestRoom'])->name('user.requestRoom');

        // User complain
        Route::get('/complain/{filter?}', [ComplainController::class, 'userComplain'])->defaults('filter', 'all')->name('user.complain');

        // Visitor management
        Route::get('/visitor/', [VisitorController::class, 'userVisitor'])->defaults('filter', 'all')->name('user.visitor');
        Route::post('/visitor/', [VisitorController::class, 'visitorRequest'])->defaults('filter', 'all')->name('user.visitorRequest');
        Route::post('/visitorLeave/', [VisitorController::class, 'visitorLeave'])->defaults('filter', 'all')->name('user.visitorLeave');
    });

    Route::group(['prefix' => 'admin',/* 'middleware' => 'admin_auth'*/], function () {
        Route::get('/', function () {
            return Inertia::render('Admin/Dashboard');
        })->name('admin.dashboard');

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

        Route::get('complain/index/{filter?}', [ComplainController::class, 'index'])->defaults('filter', 'all')->name('complain.index');
        Route::post('complain/{complain}', [ComplainController::class, 'complainProgress'])->name('complain.complainProgress');
        Route::resource('complain', ComplainController::class, ['except' => ['update', 'index']]);

        // Visitor management
        Route::post('visitor/approve', [VisitorController::class, 'visitorApprove'])->name('visitor.approve');
        Route::resource('visitor', VisitorController::class);

        // User Controller
        Route::resource('user', UserInfoController::class);

        // Room Services Controller
        Route::resource('services', GeneralServicesController::class);
    });
});

require __DIR__ . '/auth.php';
