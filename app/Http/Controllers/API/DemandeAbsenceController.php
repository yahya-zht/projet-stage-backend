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
        $DemandeAbsence =
            DemandeAbsence::with('personne')->get();
        return response()->json(["DemandeAbsence" => $DemandeAbsence]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dateDemande' => 'required',
            'dateDebut' => 'required',
            'dateFin' => 'required',
            "type" => "required",
            "duree" => "required",
            // 'personne_id' => 'required',
        ]);
        $user = $request->user();
        $idP = $user->personne_id;
        // $randomString = strtoupper(str_shuffle('ABCDEFGHIJKLMNPOQRSTUVWXYZ0123456789'));
        $randomString = strtoupper(str_shuffle('0123456789'));
        $randomString = substr($randomString, 0, 5);
        $Ref = "RF" . $randomString;
        // $Ref = uniqid();
        $DemandeAbsence = DemandeAbsence::create(array_merge($request->all(), ['Ref' => $Ref, 'personne_id' => $idP]));
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
            // 'personne_id' => 'required',
        ]);
        $user = $request->user();
        $idP = $user->personne_id;
        $DemandeAbsence->fill(array_merge($request->all(), ['personne_id' => $idP]));
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
    public function ListDemandeAbsenceAdmin(Request $request)
    {
        $user = $request->user();
        $user->load('personne.etablissement');
        $r = $user->personne->role;
        if ($r === "Directeur") {
            $id = $user->personne->etablissement_id;
            $absenceDirecteur = DemandeAbsence::select('*', 'demande_absences.id as idA')
                ->join('personnes', 'personnes.id', '=', 'demande_absences.personne_id')
                ->where('personnes.etablissement_id', $id)
                ->where('état', 'En Attendant')
                ->get();
            return response()->json(["demandesEnAttente" => $absenceDirecteur]);
        } elseif ($r === "Admin") {
            $absenceDirecteur = DemandeAbsence::select('*', 'demande_absences.id as idA')
                ->where('état', 'En Attendant')->with('personne')
                ->get();
            return response()->json(["demandesEnAttente" => $absenceDirecteur]);
        }
        return false;
    }

    public function DemandeReject(string $id)
    {
        $DemandeAbsence = DemandeAbsence::find($id);
        $DemandeAbsence->état = "REJETÉ";
        $DemandeAbsence->update();
        return response()->json(["DemandeAbsence" => $DemandeAbsence, "message" => "Successfully updated"]);
    }
}
