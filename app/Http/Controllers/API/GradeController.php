<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Grade = Grade::all();
        return response()->json(["AllGrade" => $Grade]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required',
            'salaire' => 'required',
        ]);
        $Grade = Grade::create($request->all());
        return response()->json(["Grade" => $Grade, 'message' => 'Grade created successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Grade $Grade)
    {
        return response()->json([$Grade => "Grade"]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grade $Grade)
    {
        $request->validate([
            'libelle' => 'required',
            'salaire' => 'required',
        ]);
        $Grade->fill($request->all());
        $Grade->update();
        return response()->json([$Grade => "Grade", 'Message' => 'Grade updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $Grade)
    {
        $Grade->delete();
        return response()->json(["message" => "Deleted successfully"]);
    }
}
