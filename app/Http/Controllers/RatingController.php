<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use Inertia\Inertia;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res = Rating::all();
        return Inertia::render('Admin/Room/Rating',[
            'data'=>$res
        ]);
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rating' => ['required', 'integer','max:5','min:1'],
            'increment_amount' => ['required', 'integer','min:1'],
            'service' => ['required','unique:ratings,service'],
        ]);

        $rating = Rating::create($request->all());

        if ($rating) {
            return response()->json(['data' => $rating, 'message' => 'rating added'], 200);
        } else {
            return response()->json(['data' => [], 'message' => 'failed'], 500);
            // return  back()->with('error', 'Failed to created ');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rating $rating)
    {
        $request->validate([
            'rating' => ['required', 'integer','max:5','min:1'],
            'increment_amount' => ['required', 'integer','min:1'],
            'service' => ['required','unique:ratings,service,'.$rating->id],
        ]);

        $update = $rating->update($request->all());

        if ($update) {
            return response()->json(['data' => $rating, 'message' => 'rating updated'], 200);
        } else {
            return response()->json(['data' => [], 'message' => 'Server error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rating $rating)
    {
        $rating->delete();
        return back()->with('message','deleted');
    }

    public function activeInactive($rating){
        $res = Rating::where('id',$rating)->first();
        if($res){
            $res->update(['is_active' => (!$res->is_active)]);
            return response()->json(['data' => [], 'message' => 'updated'], 200);
        }else{
            return response()->json(['data' => [], 'message' => 'Not found'], 404);
        }
    }
}
