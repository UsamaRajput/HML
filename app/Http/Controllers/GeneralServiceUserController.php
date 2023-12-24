<?php

namespace App\Http\Controllers;

use App\Models\GeneralServices;
use App\Models\GeneralServiceUser;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class GeneralServiceUserController extends Controller
{
    public function index()
    {
        $services = GeneralServices::withcount(['users'=>function($qry){
           return $qry->where('users.id',auth()->user()->id)->where('user_service.status',0);
        }])->where('is_active',1)->get();

        return Inertia::render('User/Services/List',[
            'data'=>$services
        ]);
    }
    public function store(Request $req)
    {
        $data = $req->all();

        $data['user_id'] =  Auth::user()->id;
        $addservice = DB::table('user_service')->insert($data);
        if ($addservice) {
            return response()->json(['data' => $addservice, 'message' => 'Service Request added'], 200);
        } else {
            return response()->json(['data' => [], 'message' => 'failed'], 500);
        }
    }

    public function service_history($id){
        $services = DB::table('user_service')->where('user_id',auth()->user()->id)->where('general_service_id',$id)->get();
         if ($services) {
             return response()->json(['data' => $services, 'message' => 'Service request history'], 200);
         } else {
             return response()->json(['data' => [], 'message' => 'failed'], 500);
         }
    }


}
