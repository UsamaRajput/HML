<?php

namespace App\Http\Controllers;

use App\Models\Security;
use App\Models\User;
use App\Models\UserInfo;
use Inertia\Inertia;
use Illuminate\Http\Request;

class SecurityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    

    public function security() {
        $res = User::leftJoin('securities','securities.user_id','users.id')
        ->leftJoin('user_infos','user_infos.user_id','users.id')
        ->selectRaw("
            users.id as user_id,
            users.name as name,
            users.email as email,
            user_infos.security_pay as security_pay,
            sum(securities.deduction) as remaining_security
        ")
        ->groupBy(
            'users.id',
            'users.name',
            'users.email',
            'user_infos.security_pay'
        )
        ->get();
        // dd($res);
        return Inertia::render('Admin/User/Security',[
            'data'=> $res
        ]);
    }

    public function deduction_history($id){
        $res = \DB::table('securities')->where('user_id',$id)->orderByDesc('created_at')->get();
        return response()->json(['data'=> $res ,'message'=>'All history']);
    }


    public function add_deduction(Request $request){
        $res = Security::create($request->all());
        $data = \DB::table('securities')->where('user_id',$request->user_id)->orderByDesc('created_at')->get();
        return response()->json(['data'=> $data ,'message'=>'added']);
    }


    public function add_security(Request $request){
        $data = UserInfo::updateOrCreate(['user_id'=>$request->user_id] ,['security_pay'=> $request->security_pay]);
        // $data = UserInfo::where('user_id',$request->user_id)->update(['security_pay'=>$request->security_pay]);
        return response()->json(['data'=> $data ,'message'=>'added']);
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
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Security $security)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Security $security)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Security $security)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Security $security)
    {
        //
    }
}
