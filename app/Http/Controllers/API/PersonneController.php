<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Personne;
use Illuminate\Http\Request;

class PersonneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $personnes = Personne::all();
        $personnes = Personne::with('fonction', 'grade', 'service', 'echelle', 'chef')->get();
        return response()->json(["Personnes" => $personnes]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'CIN' => 'required',
            'prenom' => 'required',
            'date_naissance' => 'required',
            'adresse' => 'required',
            'telephone' => 'required',
            'role' => 'required',
            // 'chef_id' => 'required',
            'grade_id' => 'required',
            'fonction_id' => 'required',
            'echelle_id' => 'required',
            'service_id' => 'required',
        ]);
        $personne = Personne::create($request->all());
        return response()->json(["Personne" => $personne, "Message" => "Successfully created"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Personne $Personne)
    {
        $Personne->load('grade', 'fonction', 'service', 'echelle', 'chef');
        return response()->json(["Personne" => $Personne]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Personne $Personne)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'date_naissance' => 'required',
            'adresse' => 'required',
            'telephone' => 'required',
            'role' => 'required',
            // 'chef_id' => 'required',
            'grade_id' => 'required',
            'fonction_id' => 'required',
            'echelle_id' => 'required',
            'service_id' => 'required',
        ]);
        $Personne->fill($request->post());
        $Personne->update();
        return response()->json(["Personne" => $Personne, "message" => "updated successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Personne $Personne)
    {
        $Personne->delete();
        return response()->json(["message" => "Deleted successfully"]);
    }
}
