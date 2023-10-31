<?php

namespace App\Http\Controllers;

use App\Models\RequestedRoom;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;


class RequestedRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res = User::with('userInfo')->get();
        //    dd($res);
        return Inertia::render('Admin/Room/Requested', [
            'data' => $res
        ]);
    }

    public function requestedRoom(Request $request)
    {
        $room =  User::with('requestedRoom')->where('id', $request->id)->first();

        if ($room) {
            return response()->json(['data' => $room, 'message' => 'ok']);
        } else {
            return response()->json(['data' => [], 'message' => 'Not found!'], 404);
        }
    }

    public function approveRoom(Request $request)
    {
        DB::beginTransaction();
        $room = Room::with(['users' => function ($query) {
            $query->whereNull('leaving_date');
        }])->where(['id' => $request->room_id, 'is_active' => 1])->first();

        $user = User::with('requestedRoom')->where(['id' => $request->user_id, 'status' => 1])->first();

        if ($room && $user) {
            try {
                if ($room->users) {
                    if ($room->users->count() < $room->capacity) {
                        DB::table('room_user')->where(['user_id'=> $user->id])->whereNull('leaving_date')->update(['leaving_date'=>date('Y-m-d',time())]);
                        DB::table('room_user')->insert(['user_id'=> $user->id,'room_id'=>$room->id]);
                        RequestedRoom::where('user_id',$user->id)->delete();
                        DB::commit();
                        return response()->json(['data' => [], 'message' => 'Room approved!']);
                    } else {
                        DB::commit();
                        return response()->json(['message' => 'Room full', 'data' => []], 202);
                    }
                } else {
                    DB::table('room_user')->where(['user_id'=> $user->id])->whereNull('leaving_date')->update(['leaving_date'=>date('Y-m-d',time())]);
                    RequestedRoom::where('user_id',$user->id)->delete();
                    DB::table('room_user')->insert(['user_id'=> $user->id,'room_id'=>$room->id]);
                    DB::commit();
                    return response()->json(['data' => [], 'message' => 'Room approved !']);
                }
            } catch (\Throwable $th) {
                DB::rollBack();
            }
        } else {
            DB::rollBack();
            return response()->json(['data' => [], 'message' => 'User or Room not active or exist'], 404);
        }
    }

    public function rejectRoom(Request $request){
        RequestedRoom::where('user_id',$request->id)->delete();
        return response()->json(['data' => [], 'message' => 'Rejected!']);
    }

    public function requestRoom(Request $request){
        RequestedRoom::create([
            "user_id" => auth()->user()->id,
            "room_id" => $request->id,
        ]);
        return response()->json(['data' => [], 'message' => 'Successfully requested room!']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => ['required', 'integer', 'exists:rooms,id'],
            'user_id' => ['required', 'integer', 'exists:users,id']
        ]);

        $requestRoom = RequestedRoom::create($request->all());
        if ($requestRoom) {
            return  back()->with('message', 'Room Requested');
        } else {
            return  back()->with('error', 'Failed to request ');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RequestedRoom $requestedRoom)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RequestedRoom $requestedRoom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RequestedRoom $requestedRoom)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequestedRoom $requestedRoom)
    {
        $res =  $requestedRoom->delete();
        if ($res) {
            return  back()->with('message', 'Room request deleted');
        } else {
            return  back()->with('error', 'Failed to delete');
        }
    }
}
