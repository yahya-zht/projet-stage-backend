<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\EtablissementService;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::with('Responsable')->get();
        return response()->json(["Services" => $services]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nom" => "required",
            "responsable_id" => "required",
            "nombre_employes" => "required",
        ]);
        $Service = Service::create($request->all());
        if ($request->etablissements_id !== null) {
            foreach ($request->etablissements_id as $etablissementId) {
                $etablissementService = new EtablissementService([
                    'etablissement_id' => $etablissementId,
                    'service_id' => $Service->id,
                ]);
                $etablissementService->save();
            }
        }

        return response()->json(["Service" => $Service, "Message" => "Successfully created"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $Service)
    {
        $Service->load('etablissement');
        return response()->json(["Service" => $Service]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $Service)
    {
        $request->validate([
            "nom" => "required",
            "responsable_id" => "required",
            "nombre_employes" => "required",
        ]);
        $Service->fill($request->all());
        $Service->update();
        if ($request->etablissements_id) {
            if ($request->has('etablissements_id')) {
                $Service->Etablissement()->sync($request->etablissements_id);
            }
        }
        return response()->json(["Service" => $Service, "Message" => "Successfully updated"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $Service)
    {
        $Service->delete();
        return response()->json(["Message" => "Successfully deleted"]);
    }
}
