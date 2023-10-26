<?php

namespace App\Http\Controllers;

use App\Models\ImageRoom;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;



class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::with('ImagesRoom')->get();
        return Inertia::render('Admin/Room/List', [
            'data' => $rooms,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return  Redirect('/room')->with('message', 'All rooms creTE ');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_number' => ['required', 'integer', 'unique:rooms,room_number'],
            'capacity' => ['required', 'integer'],
            'images' => ['nullable'],
        ]);

        $room = Room::create($request->all());

        if ($room) {
            if($request->hasFile('images')){
                $fileName = null;
                $images = $request->file('images');
                foreach($images as $key => $value){
                    $fileName = time().$value->getClientOriginalName();
                    $filename = $value->storeAs('room_images',$fileName);
                    ImageRoom::create(['image'=>$fileName,'room_id'=>$room->id]);
                }
            }
            return  back()->with('message', 'room created ');
        } else {
            return  back()->with('error', 'Failed to created ');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        $room = $room->with('ImagesRoom')->find($room->id);
        return inertia('Test/Test2', [
            'data' => $room
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {

        $request->validate([
            'room_number' => ['required', 'integer','unique:rooms,room_number,except,'.$room->id],
            'capacity' => ['required', 'integer'],
            'images' => ['nullable'],
        ]);

        $update = $room->update($request->all());

        if ($update) {
            if($request->hasFile('images')){
                $fileName = null;
                $images = $request->file('images');
                foreach($images as $key => $value){
                    $fileName = time().$value->getClientOriginalName();
                    $value->storeAs('room_images',$fileName);
                    ImageRoom::create(['image'=>$fileName,'room_id'=>$room->id]);
                }
            }
            return  back()->with('message', 'room updated ');
        } else {
            return  back()->with('error', 'Failed to update ');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room = $room->with('ImagesRoom')->find($room->id);

        foreach($room->ImagesRoom as $key => $value){
            if(Storage::exists('room_images/'.$value->image)){
                Storage::delete('room_images/'.$value->image);
            }
        }

        $room->delete();

        return redirect(route('room.index'));
    }
}
