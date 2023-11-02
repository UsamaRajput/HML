<?php

namespace App\Http\Controllers;

use App\Models\UserInfo;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class UserInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $res = User::with('userInfo')->get();
       return Inertia::render('Admin/User/List',[
        'data'=>$res
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function updateProfile(Request $request)
    {
        $uesrInfo = UserInfo::updateOrCreate(['user_id'=>auth()->user()->id],$request->all());

        if ($uesrInfo) {
            return back()->with('message', 'UserInfo Updated');
        } else {
            return back()->with('error', 'Failed! Something wrong');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ]);
        if ($request->hasFile('image')) {
            $fileName = null;
            $image = $request->file('image');
            $fileName = time() . $image->getClientOriginalName();
            $image->storeAs('user_images', $fileName);
        }
        $uesrInfo = UserInfo::create($request->all());

        if ($uesrInfo) {
            return back()->with('message', 'UserInfo added');
        } else {
            return back()->with('error', 'Failed! Something wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(UserInfo $userInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserInfo $userInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserInfo $userInfo)
    {
        $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ]);
        if ($request->hasFile('image')) {
            $fileName = null;
            $image = $request->file('image');
            $fileName = time() . $image->getClientOriginalName();
            $image->storeAs('user_images', $fileName);
        }
        $uesrInfo = $userInfo->update($request->all());

        if ($uesrInfo) {
            return back()->with('message', 'UserInfo added');
        } else {
            return back()->with('error', 'Failed! Something wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserInfo $userInfo)
    {
        $res = User::where(['id'=>$userInfo->user_id])->delete();
        if ($res) {
            return back()->with('message', 'deleted');
        } else {
            return back()->with('error', 'failed');
        }
    }

    /**
     * Change profile image
     */
    public function changeImage(Request $request){
        // dd('hi');
        $request->validate([
            'image' => ['required', 'image'],
        ]);
        if ($request->hasFile('image')) {
            $fileName = null;
            $image = $request->file('image');
            $oriFileName = time() . $image->getClientOriginalName();
            $filename = $image->storeAs('user_images', $oriFileName);
            if($filename){
                $res = UserInfo::updateOrCreate(['user_id'=>auth()->user()->id],['image'=>$oriFileName]);
                if($res){
                   return response()->json(['data'=>['image'=>$oriFileName],'message'=>'image change']);
                }else{
                    return response()->json(['data'=>[],'message'=>'Failed to change'],500);
                }
            }else{
                return response()->json(['data'=>[],'message'=>'Something wrong'],500);
            }
        }else{
            return response()->json(['data'=>[],'message'=>'Please upload image'],500);
        }
    }
}
