<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\EtablissementService;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $Service->load('etablissement', 'employees.Grade', 'employees.Fonction', 'employees.Echelle', 'employees.Chef', 'employees.service', 'Responsable');
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
    public function getServicesForEtablissement(Request $request)
    {
        $user = $request->user();
        $user->load('personne');
        $idE = $user->personne->etablissement_id;
        // $services = Service::whereHas('Etablissement', function ($query) use ($idE) {
        //     $query->where('etablissement_id', $idE);
        // })
        //     ->with('Etablissement')
        //     ->get();
        // $services = DB::table('etablissements_services')
        //     ->join('services', 'etablissements_services.service_id', '=', 'services.id')
        //     ->where('etablissements_services.etablissement_id', $idE)
        //     ->select('services.*')
        //     ->get();
        $services = Service::select('services.*', 'ES.nombre_employes')
            ->join('etablissements_services as ES', 'services.id', '=', 'ES.service_id')
            ->join('etablissements AS e', 'e.id', '=', 'ES.etablissement_id')
            ->where('ES.etablissement_id', $idE)->with('Responsable')
            ->get();
        return response()->json(["Services" => $services]);
    }
}
