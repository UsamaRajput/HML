<?php

namespace App\Http\Controllers;

use App\Models\GeneralServices;
use App\Models\GeneralServiceUser;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class GeneralServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res = GeneralServices::withCount('users')->get();
        return Inertia::render('Admin/Gservices/List', [
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
        $res = GeneralServices::create($request->all());
        if ($res) {
            return response()->json(['data' => $res, 'message' => 'Service added'], 200);
        } else {
            return response()->json(['data' => [], 'message' => 'failed'], 500);
            // return  back()->with('error', 'Failed to created ');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $res = GeneralServices::with('users')->where('id',$request->service)->first();
        if ($res) {
            return response()->json(['data' => $res, 'message' => 'Service record'], 200);
        } else {
            return response()->json(['data' => [], 'message' => 'failed'], 500);
            // return  back()->with('error', 'Failed to created ');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GeneralServices $generalServices)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request )
    {
        $res = GeneralServices::where('id',$request->id)->update(['name'=>$request->name]);
        if ($res) {
            return response()->json(['data' => $res, 'message' => 'Service updated'], 200);
        } else {
            return response()->json(['data' => [], 'message' => 'failed'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    { 
        GeneralServices::where('id',$id)->delete();
        return redirect()->back();
    }

    public function approveAction(Request $request) {

        $status = $request->status == 'approve' ? 1:2;
        $res = DB::table('user_service')->where(['user_id'=>$request->user_id,'general_service_id'=>$request->service_id])->update(['status'=>$status]);
        if ($res) {
            return response()->json(['data' => $res, 'message' => 'Service '.$request->status], 200);
        } else {
            return response()->json(['data' => [], 'message' => 'failed'], 500);
        }
    }
}
