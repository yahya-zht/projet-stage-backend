<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DemandeAbsence;
use Illuminate\Http\Request;

class DemandeAbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $DemandeAbsence = DemandeAbsence::all();
        return response()->json(["DemandeAbsence" => $DemandeAbsence]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dataDemande' => 'required',
            'dataDebut' => 'required',
            'dataFin' => 'required',
            'état' => 'required',
            'absence_id' => 'required',
            'personne_id' => 'required',
        ]);
        $DemandeAbsence = DemandeAbsence::create($request->all());
        return response()->json(["DemandeAbsence" => $DemandeAbsence, "message" => "Successfully created"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(DemandeAbsence $DemandeAbsence)
    {
        return response()->json(["DemandeAbsence" => $DemandeAbsence]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DemandeAbsence $DemandeAbsence)
    {
        $request->validate([
            'dataDemande' => 'required',
            'dataDebut' => 'required',
            'dataFin' => 'required',
            'état' => 'required',
            'absence_id' => 'required',
            'personne_id' => 'required',
        ]);
        $DemandeAbsence->fill($request->all());
        $DemandeAbsence->update();
        return response()->json(["DemandeAbsence" => $DemandeAbsence, "message" => "Successfully updated"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DemandeAbsence $DemandeAbsence)
    {
        $DemandeAbsence->delete();
        return response()->json(["message" => "Deleted successfully"]);
    }
}
