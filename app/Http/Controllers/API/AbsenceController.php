<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\DemandeAbsence;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{

    public function index()
    {
        $Absences =
            Absence::with('personne', 'DemandeAbsence')->get();
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
    public function CreateAbsence(string $id)
    {
        $DemandeAbsence = DemandeAbsence::find($id);
        $Absence = new Absence();
        $Absence->date_debut = $DemandeAbsence->dateDebut;
        $Absence->date_fin = $DemandeAbsence->dateFin;
        $Absence->duree = $DemandeAbsence->duree;
        $Absence->type = $DemandeAbsence->type;
        $Absence->personne_id = $DemandeAbsence->personne_id;
        $Absence->demande_absence_id = $DemandeAbsence->id;
        $Absence->save();
        $DemandeAbsence->état = "Acceptable";
        $DemandeAbsence->update();
        return response()->json(["Absence" => $Absence, "Message" => "Successfully created & updated état Demande"]);
    }
}
