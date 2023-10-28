<?php

namespace App\Http\Controllers;

use App\Models\Complain;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ComplainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res = Complain::with('user')->get();
        return Inertia::render('Admin/Complain/List', [
            'data' => $res
        ]);
    }

    public function complainProgress(Request $request, Complain $complain)
    {
        $res = $complain->update([$request->fieldName => !$complain->{$request->fieldName}]);
        if ($res) {
            return response()->json(['data' => [], "message" => "Status Updated Successfully"]);
        } else {
            return response()->json(['data' => [], "message" => "Failed to update status"], 500);
        }
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
    public function show(Complain $complain)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Complain $complain)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Complain $complain)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complain $complain)
    {
        $complain->delete();
        return back()->with('message','Deleted!');
    }
}
