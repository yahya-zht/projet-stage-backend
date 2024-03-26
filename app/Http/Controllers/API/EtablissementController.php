<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Etablissement;
use App\Models\EtablissementService;
use Illuminate\Http\Request;

class EtablissementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Etablissements = Etablissement::with('Directeur')->get();
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
        if ($request->services_id !== null) {
            foreach ($request->services_id as $serviceId) {
                $etablissementService = new EtablissementService([
                    'service_id' => $serviceId,
                    'etablissement_id' => $Etablissement->id,
                ]);
                $etablissementService->save();
            }
        }

        return response()->json(["Etablissement" => $Etablissement, "Message" => "Successfully created"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Etablissement $Etablissement)
    {
        $Etablissement->load('service.Responsable', 'Directeur');
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
        if ($request->services_id) {
            if ($request->has('services_id')) {
                $Etablissement->Service()->sync($request->services_id);
            }
        }
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
