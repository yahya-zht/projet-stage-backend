<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Conge;
use App\Models\DemandeConge;
use Illuminate\Http\Request;

class CongeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Conges = Conge::all();
        return response()->json(["Conges" => $Conges]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "date_debut" => "required",
            "date_fin" => "required",
            "duree" => "required",
            // "type" => "required", n 
            "personne_id" => "required",
            "demande_conge_id" => "required",
        ]);
        $Conge = Conge::create($request->all());
        return response()->json(["Conge" => $Conge, "Message" => "Successfully created"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Conge $Conge)
    {
        return response()->json(["Conge" => $Conge]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Conge $Conge)
    {
        $request->validate([
            "date_debut" => "required",
            "date_fin" => "required",
            "duree" => "required",
            "type" => "required",
            "personne" => "required",
        ]);
        $Conge->fill($request->all());
        $Conge->update();
        return response()->json(["Conge" => $Conge, "Message" => "Successfully updated"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Conge $Conge)
    {
        $Conge->delete();
        return response()->json(["Message" => "Successfully deleted"]);
    }
    public function CreateConge(string $id)
    {
        $DemandeConge = DemandeConge::find($id);
        $Conge = new Conge();
        $Conge->date_debut = $DemandeConge->dateDebut;
        $Conge->date_fin = $DemandeConge->dateFin;
        $Conge->duree = $DemandeConge->duree;
        $Conge->type = $DemandeConge->type;
        $Conge->personne_id = $DemandeConge->personne_id;
        $Conge->demande_conge_id = $DemandeConge->id;
        $Conge->save();
        $DemandeConge->état = "Acceptable";
        $DemandeConge->update();
        return response()->json(["Conge" => $Conge, "Message" => "Successfully created & updated état Demande"]);
    }
}
