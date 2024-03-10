<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Echelle;
use Illuminate\Http\Request;

class EchelleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Echelles = Echelle::all();
        return response()->json(["Echelles" => $Echelles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required',
            'niveau' => 'required',
        ]);
        $Echelle = Echelle::create($request->all());
        return response()->json(["Echelle" => $Echelle, "Message" => "Successfully created"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Echelle $Echelle)
    {
        return response()->json(["Echelle" => $Echelle]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Echelle $Echelle)
    {
        $request->validate([
            'libelle' => 'required',
            'niveau' => 'required',
        ]);
        $Echelle->fill($request->all());
        $Echelle->update();
        return response()->json(["Echelle" => $Echelle, "Message" => "Successfully updated"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Echelle $Echelle)
    {
        $Echelle->delete();
        return response()->json(["Message" => "Successfully deleted"]);
    }
}
