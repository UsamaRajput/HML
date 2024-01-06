<?php

namespace App\Http\Controllers;

use App\Models\GeneralServices;
use App\Models\GeneralServiceUser;
use App\Models\User;
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
        $res = GeneralServices::withCount(['users'=>function($qry){
           return  $qry->where('user_service.status',0);
        }])->get();
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
        // dd('hi');
        $res = DB::table('user_service')->leftJoin('users','users.id','user_service.user_id')
        ->selectRaw("users.id as id, users.name as name")
        ->where('user_service.status',0)
        ->where('general_service_id',$request->service)
        ->get();
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

    public function history(Request $request){
        $res = User::withcount('generalServices')->get();
        return Inertia::render('Admin/Gservices/History', [
            'data' => $res
        ]);
    }

    public function show_hostory(Request $request) {
        $res = GeneralServices::leftjoin('user_service','user_service.general_service_id','general_services.id')

        ->where('user_service.user_id',$request->user_id)->get();
        if ($res) {
            return response()->json(['data' => $res, 'message' => 'Service Hitory '], 200);
        } else {
            return response()->json(['data' => [], 'message' => 'failed'], 500);
        }
    }
}
