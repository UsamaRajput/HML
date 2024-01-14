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
            return back()->with('message', 'UserInfo added');
        } else {
            return back()->with('error', 'Failed! Something wrong');
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
    public function update(Request $request, Staff $staff)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        $staff->delete();
        return back()->with('message', 'Deleted!');
    }
}
