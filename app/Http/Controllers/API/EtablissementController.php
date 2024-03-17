<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Etablissement;
use Illuminate\Http\Request;

class EtablissementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Etablissements = Etablissement::with('Personne')->get();
        return response()->json(["Etablissements" => $Etablissements]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nom" => "required",
            "adresse" => "required",
            "directeur_id" => "required",
        ]);
        $Etablissement = Etablissement::create($request->all());
        return response()->json(["Etablissement" => $Etablissement, "Message" => "Successfully created"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Etablissement $Etablissement)
    {
        return response()->json(["Etablissement" => $Etablissement]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Etablissement $Etablissement)
    {
        $request->validate([
            "nom" => "required",
            "adresse" => "required",
            "directeur_id" => "required",
        ]);
        $Etablissement->fill($request->all());
        $Etablissement->update();
        return response()->json(["Etablissement" => $Etablissement, "Message" => "Successfully updated"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Etablissement $Etablissement)
    {
        $Etablissement->delete();
        return response()->json(["Message" => "Successfully deleted"]);
    }
}
