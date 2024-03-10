<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Fonction;
use Illuminate\Http\Request;

class FonctionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Fonctions = Fonction::all();
        return response()->json(["Fonctions" => $Fonctions]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required',
        ]);
        $Fonction = Fonction::create($request->all());
        return response()->json(["Fonction" => $Fonction, "Message" => "Successfully created"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Fonction $Fonction)
    {
        return response()->json(["Fonction" => $Fonction]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fonction $Fonction)
    {
        $request->validate([
            'libelle' => 'required',
        ]);
        $Fonction->fill($request->all());
        $Fonction->update();
        return response()->json(["Fonction" => $Fonction, "Message" => "Successfully updated Fonction "]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fonction $Fonction)
    {
        $Fonction->delete();
        return response()->json(["Message" => "Successfully deleted Fonction"]);
    }
}
