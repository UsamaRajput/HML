<?php

namespace App\Http\Controllers;

use App\Models\RequestedRoom;
use Illuminate\Http\Request;

class RequestedRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'room_id' => ['required', 'integer','exists:rooms,id'],
            'user_id' => ['required', 'integer','exists:users,id']
        ]);

        $requestRoom = RequestedRoom::create($request->all());
        if($requestRoom){
            return  back()->with('message', 'Room Requested');
        }else{
            return  back()->with('error', 'Failed to request ');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RequestedRoom $requestedRoom)
    {
        //
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
        if($res){
            return  back()->with('message', 'Room request deleted');
        }else{
            return  back()->with('error', 'Failed to delete');
        }
    }
}
