<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DemandeConge;
use Illuminate\Http\Request;

class DemandeCongeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $DemandeConge = DemandeConge::with('personne')->get();
        return response()->json(["DemandeConge" => $DemandeConge]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "dateDemande" => "required",
            "dateDebut" => "required",
            "dateFin" => "required",
            "type" => "required",
            "duree" => "required",
        ]);
        $user = $request->user();
        $idP = $user->personne_id;
        $randomString = strtoupper(str_shuffle('0123456789'));
        $randomString = substr($randomString, 0, 5);
        $Ref = "RF" . $randomString;
        $DemandeConge = DemandeConge::create(array_merge($request->all(), ['Ref' => $Ref, 'personne_id' => $idP]));
        return response()->json(["DemandeConge" => $DemandeConge, "message" => "Successfully created"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $DemandeConge = DemandeConge::with('personne.grade', 'personne.fonction')->find($id);
        return response()->json(["DemandeConge" => $DemandeConge]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DemandeConge $DemandeConge)
    {
        $request->validate([
            "dataDemande" => "required",
            "dataDebut" => "required",
            "dataFin" => "required",
            "état" => "required",
            // "personne_id" => "required",
            "conge_id" => "required"
        ]);
        $user = $request->user();
        $idP = $user->personne_id;
        $DemandeConge->fill(array_merge($request->all(), ['personne_id' => $idP]));
        $DemandeConge->update();
        return response()->json(["DemandeConge" => $DemandeConge, "message" => "Successfully updated"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $DemandeConge = DemandeConge::find($id);
        $DemandeConge->delete();
        return response()->json(["message" => "Deleted successfully"]);
    }
    public function ListDemandeCongeAdmin(Request $request)
    {
        $user = $request->user();
        $user->load('personne.etablissement');
        $r = $user->personne->role;
        if ($r === "Directeur") {
            $id = $user->personne->etablissement_id;
            $congeDirecteur = DemandeConge::select('*', 'demande_conges.id as idC')
                ->join('personnes', 'personnes.id', '=', 'demande_conges.personne_id')
                ->where('personnes.etablissement_id', $id)
                ->where('état', 'En Attendant')
                ->get();
            return response()->json(["demandesEnAttente" => $congeDirecteur]);
        } elseif ($r === "Admin") {
            $congeDirecteur = DemandeConge::select('*', 'demande_conges.id as idC')
                ->where('état', 'En Attendant')->with('personne')
                ->get();
            return response()->json(["demandesEnAttente" => $congeDirecteur]);
        }
        return false;
    }
    public function DemandeReject(string $id)
    {
        $DemandeConge = DemandeConge::find($id);
        $DemandeConge->état = "REJETÉ";
        $DemandeConge->update();
        return response()->json(["DemandeConge" => $DemandeConge, "message" => "Successfully updated"]);
    }
}
