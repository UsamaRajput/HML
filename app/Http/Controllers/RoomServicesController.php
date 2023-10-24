<?php

namespace App\Http\Controllers;

use App\Models\RoomServices;
use Illuminate\Http\Request;

class RoomServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res = RoomServices::all();
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
            'service_name'=>['required','unique:room_services,service_name'],
            'rating'=>['required','numeric'],
            'charges'=>['required','numeric']
        ]);
        $res = RoomServices::create($request->all());
        if($res){
            return back()->with('message','Room service created');
        }else{
            return back()->with('error','Failed');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RoomServices $roomServices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoomServices $roomServices)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RoomServices $roomServices)
    {
        $request->validate([
            'service_name'=>['required','unique:room_services,service_name,except,'.$roomServices->id],
            'rating'=>['required','numeric'],
            'charges'=>['required','numeric']
        ]);
        $res = $roomServices->update($request->all());
        if($res){
            return back()->with('message','Room service created');
        }else{
            return back()->with('error','Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoomServices $roomServices)
    {
        $roomServices->delete();
        return back()->with('message','deleted');
    }
}
