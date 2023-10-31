<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Inertia\Inertia;
use Illuminate\Http\Request;

class VisitorController extends Controller
{

    public function userVisitor()
    {
        $res = Visitor::with('room')->where('user_id', auth()->user()->id)->get();
        return Inertia::render('User/Visitor/Index', [
            'data' => $res
        ]);
    }

    public function visitorRequest(Request $request)
    {
        $res = Visitor::create([
            "name" => $request->input("name"),
            "visit" => $request->input("visit"),
            'user_id' => auth()->user()->id,
            'room_id' => auth()->user()->current_room->first()->id,
        ]);

        if ($res) {
            return response()->json(['data' => $res, 'message' => 'Requested'], 200);
        } else {
            return response()->json(['data' => [], 'message' => 'failed'], 500);
        }
    }


    public function visitorLeave(Request $request)
    {
        $res = Visitor::where('id',$request->id)->update([
            'leave'=>$request->leave
        ]);

        if ($res) {
            return response()->json(['data' => $res, 'message' => 'Done'], 200);
        } else {
            return response()->json(['data' => [], 'message' => 'failed'], 500);
        }

    }
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Visitor $visitor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Visitor $visitor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Visitor $visitor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visitor $visitor)
    {
        //
    }
}
