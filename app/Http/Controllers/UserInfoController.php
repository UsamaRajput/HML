<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\UserInfo;
use App\Models\User;
use App\Models\Security;
use Inertia\Inertia;
use Illuminate\Http\Request;

class UserInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd('ds');
       $res['users'] = User::with(['userInfo','rooms'=>function($qry){
        return $qry->whereNull('leaving_date');
       }])->get();

       $res['rooms'] = Room::withCount(['users'=>function($qry){
        return $qry->whereNull('leaving_date');
       }])->where('is_active',1)->get();
    //    dd($res['rooms']);
       return Inertia::render('Admin/User/List',[
        'data'=>$res
        ]);
    }


    function addUser(Request $request) {
        // dd('da');
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Hash::make($request->password),
        ]);
        $infoData = $request->all();

         if ($request->hasFile('image')) {
            $fileName = null;
            $image = $request->file('image');
            $fileName = time() . $image->getClientOriginalName();
            $image->storeAs('user_images', $fileName);
            $infoData['image'] =  $fileName;
        }

        $infoData['user_id'] = $user->id;
        $uesrInfo = UserInfo::create($infoData);
       
        if ($uesrInfo) {
            return back()->with('message', 'UserInfo Updated');
        } else {
            return back()->with('error', 'Failed! Something wrong');
        }
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
    public function edit($id)
    {
        // $id = $request->user_id;
        $res = User::leftjoin('user_infos','users.id','user_infos.user_id')
        ->selectRaw("
            user_infos.*,
            users.*,
            user_infos.user_id as user_id,
            users.id as id
        ")
        ->where('users.id',$id)->first();
        if ($res) {
            return response()->json(['data'=>$res]);
        } else {
            return response()->json(['data'=>[],'message'=>'Not found!'],404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    { 
        User::where('id',$request->id)->update([
            'name'=>$request->name,
            'email'=>$request->email,
            // 'password'=>$request->password,
        ]);

        $userInfoData = $request->all();
        if ($request->hasFile('image')) {
            $fileName = null;
            $image = $request->file('image');
            $fileName = time() . $image->getClientOriginalName();
            $image->storeAs('user_images', $fileName);
            $userInfoData['image'] = $fileName;
        }
        $uesrInfo = UserInfo::updateOrCreate(['user_id'=>$request->id],$userInfoData);

        if ($uesrInfo) {
            return back()->with('message', 'UserInfo added');
        } else {
            return back()->with('error', 'Failed! Something wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($userInfo)
    {
        $res = User::where(['id'=>$userInfo])->delete();
        UserInfo::where(['user_id'=>$userInfo])->delete();
        \DB::table('room_user')->where(['user_id'=> $userInfo])->delete();
        if ($res) {
            return back()->with('message', 'deleted');
        } else {
            return back()->with('error', 'failed');
        }
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