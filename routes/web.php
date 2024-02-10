<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ComplainController;
use App\Http\Controllers\GeneralServicesController;
use App\Http\Controllers\GeneralServiceUserController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\RequestedRoomController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\MessController;
use App\Http\Controllers\WebContentController;
use App\Models\Complain;
use App\Models\GeneralServices;
use App\Models\Room;
use App\Models\Staff;
use App\Models\User;
use App\Models\Visitor;
use App\Models\WebContent;
use Illuminate\Http\Request;
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
    $data['main_content'] = WebContent::first();
    $data['services'] = GeneralServices::where('is_active',1)->get();
    $data['rooms'] = Room::with(['ImagesRoom','users'=>function($qry){
        return $qry->whereNull('leaving_date');
       }])
    ->selectRaw('
        sum(ratings.increment_amount) AS amount, rooms.id ,
        avg(ratings.rating) AS rating,
        rooms.room_number,
        rooms.capacity,
        rooms.price,
        rooms.is_active
     ')
    ->leftjoin('room_ratings','rooms.id','room_ratings.room_id')
    ->leftjoin('ratings','ratings.id','room_ratings.rating_id')
    ->groupBy(
        'rooms.id',
        'rooms.room_number',
        'rooms.capacity',
        'rooms.price',
        'rooms.is_active'
    )
    ->where('rooms.is_active',1)
    ->orderBy('room_number', 'ASC')
    ->get();

    $data['staff'] = Staff::where('active',1)->get();

   return Inertia::render('Welcome', [
        'data'=>$data
       ]);
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

Route::post('/contactMail', function (Request $request) {
     \Mail::send([], [], function ($m) use ($request) {
        // $m->from($request->email);
        $m->text("Client Email ".$request->email."\n"."Message ".$request->message);  
        $m->to('rajputhusama@gmail.com', $request->name)->subject("Contact Us Mail");
    });
    return response()->json([  'message' => 'Mail sent successfully'], 200);
})->name('contactMail');


// Route::resource('room', RoomController::class);


Route::middleware('auth')->group(function () {
Route::group(['prefix' => 'user',/* 'middleware' => 'user_auth'*/], function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.edit');
        Route::post('/change_image', [UserInfoController::class, 'changeImage'])->name('profile.changeImage');
        Route::post('/profile', [UserInfoController::class, 'updateProfile'])->name('profile.updateProfile');
        // User Room
        Route::get('/rooms', [RoomController::class, 'userRooms'])->name('user.rooms');
        Route::post('/requestRoom', [RequestedRoomController::class, 'requestRoom'])->name('user.requestRoom');

        //service:
        Route::get('/service',[GeneralServiceUserController::class,'index'])->name('user.service');
        Route::post('/service/cancel',[GeneralServiceUserController::class,'service_cancel'])->name('service.cancel');
        Route::get('/service_history/{id}',[GeneralServiceUserController::class,'service_history'])->name('service.history');
        Route::post('/service/request',[GeneralServiceUserController::class,'store'])->name('service.request');
        // User complain
        Route::get('/complain/{filter?}', [ComplainController::class, 'userComplain'])->defaults('filter', 'all')->name('user.complain');
        
        // Mess
        Route::get('/mess', [MessController::class, 'user_mess'])->defaults('filter', 'all')->name('user.mess');
        // Visitor management
        Route::get('/visitor/', [VisitorController::class, 'userVisitor'])->defaults('filter', 'all')->name('user.visitor');
        Route::post('/visitor/', [VisitorController::class, 'visitorRequest'])->defaults('filter', 'all')->name('user.visitorRequest');
        Route::post('/visitorLeave/', [VisitorController::class, 'visitorLeave'])->defaults('filter', 'all')->name('user.visitorLeave');
    });

    Route::group(['prefix' => 'admin',/* 'middleware' => 'admin_auth'*/], function () {
        Route::get('/', function () {
            $data['user_count'] = User::count();
            $data['room_count'] = Room::count();
            $data['complain_count'] = Complain::where('closed',0)->count();
            $data['visitor_count'] = Visitor::whereDate('visit',date('Y-m-d'))->count();
            return Inertia::render('Admin/Dashboard',['data'=>$data]);
        })->name('admin.dashboard');

        Route::post('room/{room}', [RoomController::class, 'update'])->name('room.update');
        Route::post('room_history', [RoomController::class, 'room_history'])->name('room.history');
        Route::post('room/{room}/test', [RoomController::class, 'test'])->name('room.test');
        Route::get('room/{room}/activeInactive', [RoomController::class, 'activeInactive'])->name('room.activeInactive');
        Route::resource('room', RoomController::class, ['except' => ['update']]);

        Route::post('requested_room', [RequestedRoomController::class, 'requestedRoom'])->name('requested.requestedRoom');
        Route::post('approve_room', [RequestedRoomController::class, 'approveRoom'])->name('requested.approveRoom');
        Route::post('remove_user_room', [RequestedRoomController::class, 'removeUserRoom'])->name('remove.UserRoom');
        Route::post('reject_room', [RequestedRoomController::class, 'rejectRoom'])->name('requested.rejectRoom');
        Route::resource('requested', RequestedRoomController::class);

        Route::get('rating/{rating}/activeInactive', [RatingController::class, 'activeInactive'])->name('rating.activeInactive');
        Route::post('rating/{rating}', [RatingController::class, 'update'])->name('rating.update');
        Route::post('room_rating', [RatingController::class, 'room_rating'])->name('rating.room');
        Route::post('add_remove_room_rating', [RatingController::class, 'add_remove_room_rating'])->name('rating.addRemoveRoom');
        Route::resource('rating', RatingController::class, ['except' => ['update']]);

        Route::get('complain/index/{filter?}', [ComplainController::class, 'index'])->defaults('filter', 'all')->name('complain.index');
        Route::post('complain/{complain}', [ComplainController::class, 'complainProgress'])->name('complain.complainProgress');
        Route::resource('complain', ComplainController::class, ['except' => ['update', 'index']]);

        // Visitor management
        Route::post('visitor/approve', [VisitorController::class, 'visitorApprove'])->name('visitor.approve');
        Route::resource('visitor', VisitorController::class);

        // User Controller
        Route::post('add/user', [UserInfoController::class, 'addUser'])->name('add.user');
        Route::post('update/user', [UserInfoController::class, 'update'])->name('update.user');
        Route::resource('user', UserInfoController::class,['except' => ['update']]);

        /**
         * Security Controler
         */
        Route::post('security/add', [SecurityController::class, 'add_security'])->name('security.add');
        Route::get('security/user', [SecurityController::class, 'security'])->name('security.user');
        Route::get('deduction/{id}/history', [SecurityController::class, 'deduction_history'])->name('deduction.history');
        Route::post('deduction/add', [SecurityController::class, 'add_deduction'])->name('deduction.add');

        // Room Services Controller
        Route::get('service/history',[GeneralServicesController::class,'history'])->name('services.uhistory');
        Route::post('service/show/history',[GeneralServicesController::class,'show_hostory'])->name('services.show_hostory');
        Route::post('service/approveAction',[GeneralServicesController::class,'approveAction'])->name('services.approveAction');
        Route::post('service/updated',[GeneralServicesController::class,'update'])->name('services.updated');
        Route::resource('services', GeneralServicesController::class);

        // Staff Controller
        Route::resource('staff', StaffController::class);
        
        /**
         * Mess
         */
        Route::post('mess/update',[MessController::class,'update'])->name('mess.update');
        Route::resource('mess', MessController::class,['except' => ['update']]);

        // Webcontent Management
        Route::post('web_content/update', [WebContentController::class, 'update'])->name('webcontent.update');
        Route::get('web_content', [WebContentController::class, 'index'])->name('webcontent.index');
    });
});
Route::get('room/moreDetails/{id?}', [RoomController::class,'roomDetail'])->name('user.room_details');

require __DIR__ . '/auth.php';
