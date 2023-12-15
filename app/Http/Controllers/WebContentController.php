<?php

namespace App\Http\Controllers;

use App\Models\WebContent;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WebContentController extends Controller
{
    function index()  {

        $res = WebContent::first();
        return Inertia::render('Admin/WebContent/Index',[
            'data'=>$res
        ]);
    }

    function update(Request $request)  {
        $res =   WebContent::where('id',$request->id)->update($request->all());

        if ($res) {
            return response()->json(['data' => $res, 'message' => 'Updated!']);
        } else {
            return response()->json(['data' => [], 'message' => 'Failed'], 500);
        }
    }
}
