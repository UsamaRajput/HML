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
        $rooms = Room::with('ImagesRoom')
        ->selectRaw('
            sum(ratings.increment_amount) AS amount, rooms.id ,
            rooms.room_number,
            rooms.capacity,
            rooms.is_active
         ')
        ->leftjoin('room_ratings','rooms.id','room_ratings.room_id')
        ->leftjoin('ratings','ratings.id','room_ratings.id')
        ->groupBy(
            'rooms.id',
            'rooms.room_number',
            'rooms.capacity',
            'rooms.is_active'
        )
        ->orderBy('room_number', 'ASC')
        ->get();
        // dd($rooms);
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

        $request['is_active'] = 1;

        $room = Room::create($request->all());

        if ($room) {
            if ($request->hasFile('images')) {
                $fileName = null;
                $images = $request->file('images');
                foreach ($images as $key => $value) {
                    $fileName = time() . $value->getClientOriginalName();
                    $filename = $value->storeAs('room_images', $fileName);
                    ImageRoom::create(['image' => $fileName, 'room_id' => $room->id]);
                }
            }
            return response()->json(['data' => $room, 'message' => 'room added'], 200);
        } else {
            return response()->json(['data' => [], 'message' => 'failed'], 500);
            // return  back()->with('error', 'Failed to created ');
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
            'room_number' => ['required', 'integer', 'unique:rooms,room_number,'.$room->id],
            'capacity' => ['required', 'integer'],
            'images' => ['nullable'],
        ]);

        $update = $room->update($request->all());

        if ($update) {
            if ($request->hasFile('images')) {
                $fileName = null;
                $images = $request->file('images');
                foreach ($images as $key => $value) {
                    $fileName = time() . $value->getClientOriginalName();
                    $value->storeAs('room_images', $fileName);
                    ImageRoom::create(['image' => $fileName, 'room_id' => $room->id]);
                }
            }
            return response()->json(['data' => $room, 'message' => 'room updated'], 200);
        } else {
            return response()->json(['data' => [], 'message' => 'Server error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room = $room->with('ImagesRoom')->find($room->id);

        foreach ($room->ImagesRoom as $key => $value) {
            if (Storage::exists('room_images/' . $value->image)) {
                Storage::delete('room_images/' . $value->image);
            }
        }

        $room->delete();

        return back()->with('message','deleted');
    }

    public function activeInactive($room){
        $res = Room::where('id',$room)->first();
        if($res){
            $res->update(['is_active' => (!$res->is_active)]);
            return response()->json(['data' => [], 'message' => 'updated'], 200);
        }else{
            return response()->json(['data' => [], 'message' => 'Not found'], 404);
        }
    }


    /**
     * User Section code
     */

     public function userRooms(){
        // $rooms = Auth::user()->rooms()->paginate(10);
        $rooms = Room::with('ImagesRoom')
        ->where('is_active',1)
        ->orderBy('room_number', 'ASC')->get();

        return Inertia::render('User/Room/Index', [
            'data' => $rooms,
        ]);

     }
}
