<?php

namespace App\Http\Controllers;

use App\Models\GeneralServiceUser;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class GeneralServiceUserController extends Controller
{
    public function index()
    {
        $room_name = Room::all();
        return Inertia::render('User/Services/AddServices',[
            'data'=>$room_name
        ]);
    }
    public function store(Request $req)
    {
        $req->validate([
            'room_id' => 'required',
            'requested_time' => 'required|time|time_format:H:i:s',
            'leaving_time' => 'required|time|time_format:H:i:s',
        ]);
        
        
        $data = $req->all();
        // dd($data);
        $data['user_id'] =  Auth::user()->id;
        $addservice = GeneralServiceUser::create($data);
        if ($addservice) {
            return response()->json(['data' => $addservice, 'message' => 'Service Reqquest added'], 200);
        } else {
            return response()->json(['data' => [], 'message' => 'failed'], 500);
            // return  back()->with('error', 'Failed to created ');
        }
    }
}
