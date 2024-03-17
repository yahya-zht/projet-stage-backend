<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
        return response()->json(["Service" => $Service, "Message" => "Successfully created"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $Service)
    {
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
