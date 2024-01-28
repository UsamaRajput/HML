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

        $webdata = $request->all();
        if ($request->hasFile('superintendent_image')) {
            $fileName = null;
            $image = $request->file('superintendent_image');
            $fileName = time() . $image->getClientOriginalName();
            $fileName = str_replace(' ','_',$fileName);
            $image->storeAs('main_images', $fileName);
            $webdata['superintendent_image'] = $fileName;
        }

        if ($request->hasFile('banner')) {
            $fileName = null;
            $image = $request->file('banner');
            $fileName = time() . $image->getClientOriginalName();
            $fileName = str_replace(' ','_',$fileName);
            $image->storeAs('main_images', $fileName);
            $webdata['banner'] = $fileName;
        }

        $res =   WebContent::where('id',$request->id)->update($webdata);

        if ($res) {
            return response()->json(['data' => $res, 'message' => 'Updated!']);
        } else {
            return response()->json(['data' => [], 'message' => 'Failed'], 500);
        }
    }
}
