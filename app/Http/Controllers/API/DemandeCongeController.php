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
            "personne_id" => "required",
        ]);
        $randomString = strtoupper(str_shuffle('0123456789'));
        $randomString = substr($randomString, 0, 5);
        $Ref = "RF" . $randomString;
        $DemandeConge = DemandeConge::create(array_merge($request->all(), ['Ref' => $Ref]));
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
            "personne_id" => "required",
            "conge_id" => "required"
        ]);
        $DemandeConge->fill($request->all());
        $DemandeConge->update();
        return response()->json(["DemandeConge" => $DemandeConge, "message" => "Successfully updated"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DemandeConge $DemandeConge)
    {
        $DemandeConge->delete();
        return response()->json(["message" => "Deleted successfully"]);
    }
    public function ListDemandeCongeAdmin()
    {
        $demandesEnAttente = DemandeConge::where('état', 'En Attendant')
            ->with('personne')
            ->get();
        return response()->json(["demandesEnAttente" => $demandesEnAttente]);
    }
    public function DemandeReject(string $id)
    {
        $DemandeConge = DemandeConge::find($id);
        $DemandeConge->état = "REJETÉ";
        $DemandeConge->update();
        return response()->json(["DemandeConge" => $DemandeConge, "message" => "Successfully updated"]);
    }
}
