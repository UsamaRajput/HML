<?php

namespace App\Http\Controllers;

use App\Models\Mess;
use Inertia\Inertia;
use Illuminate\Http\Request;

class MessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res = Mess::orderBy('day')->get();
       
        return Inertia::render('Admin/Mess/Index', [
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
        $res = Mess::create($request->all());
        if ($res) {
            $res = Mess::orderBy('day')->get();
            return response()->json(['data' => $res, 'message' => 'Mess added'], 200);
        } else {
            return response()->json(['data' => [], 'message' => 'failed'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Mess $mess)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mess $mess)
    {
        return $mess;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {      
        $update['name'] = $request['name'];
        $update['time'] = $request['time'];
        $update['day'] = $request['day'];
        $res = Mess::where('id',$request->id)->update($update);
        if ($res) {
            $res = Mess::orderBy('day')->get();
            return response()->json(['data'=>$res,'message'=>'Mess Updated!']);
        } else {
            return response()->json(['data'=>[],'message'=>'Not found!'],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($mess)
    {
        $Mess = Mess::where('id',$mess)->delete();

        if( $Mess){
            return response()->json(['data' => [], 'message' => 'Deleted'], 200);
        }            
        return response()->json(['data' => [], 'message' => 'Server error'], 500);

    }

    public function user_mess()  {
        $res = Mess::orderBy('day')->get();
        return Inertia::render('User/Mess/Index', [
            'data' => $res
        ]);
    }
}
