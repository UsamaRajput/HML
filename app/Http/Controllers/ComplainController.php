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
    public function index($filter)
    {
        $res = Complain::with('user');

        if ($filter != 'all') {
            $res->where($filter, 1);
        }

        $res = $res->get();
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

    public function userComplain($filter)
    {
        $res = Complain::where('user_id', auth()->user()->id);
        if ($filter != 'all') {
            $res->where($filter, 1);
        }
        $res = $res->get();
        return Inertia::render('User/Complain/Index', [
            'data' => $res
        ]);
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
        $res = Complain::create(['message' => $request->message, 'user_id' => auth()->user()->id]);
        if ($res) {
            return response()->json(['data' => $res, 'message' => 'Complain added'], 200);
        } else {
            return response()->json(['data' => [], 'message' => 'failed'], 500);
            // return  back()->with('error', 'Failed to created ');
        }
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
        return back()->with('message', 'Deleted!');
    }
}
