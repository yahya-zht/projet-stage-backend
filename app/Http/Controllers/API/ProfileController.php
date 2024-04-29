<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Conge;
use App\Models\DemandeAbsence;
use App\Models\DemandeConge;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function getUserProfile(Request $request)
    {
        $user = $request->user();
        $user->load('personne.grade', 'personne.fonction', 'personne.service', 'personne.echelle', 'personne.chef', 'personne.etablissement');
        return response()->json(['user' => $user]);
    }

    public function conge(Request $request)
    {
        $user = $request->user();
        $id = $user->id;
        $Conge = Conge::where('personne_id', $id)->get();
        return response()->json(["Conge" => $Conge]);
    }
    public function absence(Request $request)
    {
        $user = $request->user();
        $id = $user->id;
        $Absence = Absence::where('personne_id', $id)->get();
        return response()->json(["Absence" => $Absence]);
    }
    public function absenceResponsable(Request $request)
    {
        $user = $request->user();
        $id = $user->id;
        $absencesResponsable = Absence::select('absences.*')
            ->join('personnes', 'personnes.id', '=', 'absences.personne_id')
            ->where('personnes.chef_id', $id)
            ->get();
        return response()->json(["AbsenceResponsable" => $absencesResponsable]);
    }
    public function congeResponsable(Request $request)
    {
        $user = $request->user();
        $id = $user->id;
        $congesResponsable = Conge::select('conges.*')
            ->join('personnes', 'personnes.id', '=', 'conges.personne_id')
            ->where('personnes.chef_id', $id)
            ->get();
        return response()->json(["congesResponsable" => $congesResponsable]);
    }
    public function absenceDirecteur(Request $request)
    {
        $user = $request->user();
        $user->load('personne.etablissement');
        $id = $user->personne->etablissement_id;
        $absenceDirecteur = Absence::select('*')
            ->join('personnes', 'personnes.id', '=', 'absences.personne_id')
            ->where('personnes.etablissement_id', $id)
            ->get();

        return response()->json(["absenceDirecteur" => $absenceDirecteur]);
    }
    public function congeDirecteur(Request $request)
    {
        $user = $request->user();
        $user->load('personne.etablissement');
        $id = $user->personne->etablissement_id;
        $congeDirecteur = Conge::select('*')
            ->join('personnes', 'personnes.id', '=', 'conges.personne_id')
            ->where('personnes.etablissement_id', $id)
            ->get();
        return response()->json(["congeDirecteur" => $congeDirecteur]);
    }
    public function demandeConge(Request $request)
    {
        $user = $request->user();
        $id = $user->id;
        $Conge = DemandeConge::where('personne_id', $id)->get();
        return response()->json(["demandeConge" => $Conge]);
    }
    public function demandeAbsence(Request $request)
    {
        $user = $request->user();
        $id = $user->id;
        $Absence = DemandeAbsence::where('personne_id', $id)->get();
        return response()->json(["demandeAbsence" => $Absence]);
    }
    public function demandeAbsenceResponsable(Request $request)
    {
        $user = $request->user();
        $user->load('personne');
        $r = $user->personne->role;
        if ($r === "Superviseur") {
            $id = $user->id;
            $demandeAbsencesResponsable = DemandeAbsence::select('*')
                ->join('personnes', 'personnes.id', '=', 'demande_absences.personne_id')
                ->where('personnes.chef_id', $id)
                ->get();
            return response()->json(["demandeAbsencesResponsable" => $demandeAbsencesResponsable]);
        }
        return false;
    }
    public function demandeCongeResponsable(Request $request)
    {
        $user = $request->user();
        $user->load('personne');
        $r = $user->personne->role;
        if ($r === "Superviseur") {
            $id = $user->id;
            $demandeCongeResponsable = DemandeConge::select('*')
                ->join('personnes', 'personnes.id', '=', 'demande_conges.personne_id')
                ->where('personnes.chef_id', $id)
                ->get();
            return response()->json(["demandeCongeResponsable" => $demandeCongeResponsable]);
        }
        return false;
    }
    public function demandeAbsenceDirecteur(Request $request)
    {
        $user = $request->user();
        $user->load('personne.etablissement');
        $r = $user->personne->role;
        if ($r === "Directeur") {
            $id = $user->personne->etablissement_id;
            $absenceDirecteur = DemandeAbsence::select('*')
                ->join('personnes', 'personnes.id', '=', 'demande_absences.personne_id')
                ->where('personnes.etablissement_id', $id)
                ->get();
            return response()->json(["absenceDirecteur" => $absenceDirecteur]);
        }
        return false;
    }
    public function demandeCongeDirecteur(Request $request)
    {
        $user = $request->user();
        $user->load('personne.etablissement');
        $r = $user->personne->role;
        if ($r === "Directeur") {
            $id = $user->personne->etablissement_id;
            $congeDirecteur = DemandeConge::select('*')
                ->join('personnes', 'personnes.id', '=', 'demande_conges.personne_id')
                ->where('personnes.etablissement_id', $id)
                ->get();
            return response()->json(["congeDirecteur" => $congeDirecteur]);
        }
        return false;
    }
}
