<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res = Staff::all();

        return Inertia::render('Admin/Staff/Index', [
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
        // $request->validate([
        //     'user_id' => ['required', 'integer', 'exists:users,id'],
        // ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $fileName = null;
            $image = $request->file('image')[0];
            $fileName = time() . $image->getClientOriginalName();
            $image->storeAs('staff_images', $fileName);
            $data['image'] = $fileName;
        }

        $uesrInfo = Staff::create($data);

        if ($uesrInfo) {
            return response()->json(['data' =>   Staff::all(), 'message' => 'updated'], 200);
        } else {
            return response()->json(['data' =>   [], 'message' => 'Failed! Something wrong'], 300);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $fileName = null;
            $image = $request->file('image')[0];
            $fileName = time() . $image->getClientOriginalName();
            $image->storeAs('staff_images', $fileName);
            $data['image'] = $fileName;
        }

        $uesrInfo = Staff::where('id', $request->id)->update($data);

        if ($uesrInfo) {
            return response()->json(['data' =>   Staff::all(), 'message' => 'updated'], 200);
        } else {
            return response()->json(['data' =>   [], 'message' => 'Failed! Something wrong'], 300);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($staff)
    {
        $staff = Staff::where('id', $staff)->delete();

        if ($staff) {
            return response()->json(['data' => [], 'message' => 'Deleted'], 200);
        }
        return response()->json(['data' => [], 'message' => 'Server error'], 500);
    }
}
