<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CertificatMedical;
use Illuminate\Http\Request;

class CertificatMedicalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $CertificatMedical = CertificatMedical::all();
        return response()->json(["CertificatMedical" => $CertificatMedical]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "dateDebut" => "required",
            "dateFin" => "required",
            "medecin" => "required",
            "diagnostic" => "required",
            "dateEmission" => "required",
            "validite" => "required",
            "etablissement" => "required",
            "absence_id" => "required",
        ]);
        $CertificatMedical = CertificatMedical::create($request->all());
        return response()->json(["CertificatMedical" => $CertificatMedical, "message" => "Successfully created"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(CertificatMedical $CertificatMedical)
    {
        return response()->json(["CertificatMedical" => $CertificatMedical]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CertificatMedical $CertificatMedical)
    {
        $request->validate([
            "dateDebut" => "required",
            "dateFin" => "required",
            "medecin" => "required",
            "diagnostic" => "required",
            "dateEmission" => "required",
            "validite" => "required",
            "etablissement" => "required",
            "absence_id" => "required",
        ]);
        $CertificatMedical->fill($request->all());
        $CertificatMedical->update();
        return response()->json(["CertificatMedical" => $CertificatMedical, "message" => "Successfully updated"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CertificatMedical $CertificatMedical)
    {
        $CertificatMedical->delete();
        return response()->json(["message" => "Deleted successfully"]);
    }
}
