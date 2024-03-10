<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{

    public function index()
    {
        $Absences = Absence::all();
        return response()->json(["Absences" => $Absences]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date_debut' => 'required',
            'date_fin' => 'required',
            'type' => 'required',
            'duree' => 'required',
            'personne_id' => 'required'
        ]);
        $Absence = Absence::create($request->all());
        return response()->json(["Absence" => $Absence, "Message" => "Successfully created"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Absence $Absence)
    {
        return response()->json(["Absence" => $Absence]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Absence $Absence)
    {
        $request->validate([
            'date_debut' => 'required',
            'date_fin' => 'required',
            'type' => 'required',
            'duree' => 'required',
            'personne_id' => 'required'
        ]);
        $Absence->fill($request->all());
        $Absence->update();
        return response()->json(["Absence" => $Absence, "Message" => "Successfully updated"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Absence $Absence)
    {
        $Absence->delete();
        return response()->json(["Message" => "Successfully deleted"]);
    }
}
