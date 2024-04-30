<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Conge;
use App\Models\DemandeAbsence;
use App\Models\DemandeConge;
use App\Models\Personne;
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
        $user->load('personne');
        $id = $user->personne_id;
        $absencesResponsable = Absence::select('*')
            ->join('personnes', 'personnes.id', '=', 'absences.personne_id')
            ->where('personnes.chef_id', $id)->orWhere('personnes.id', $id)->with('DemandeAbsence')
            ->get();
        return response()->json(["Absences" => $absencesResponsable]);
    }
    public function congeResponsable(Request $request)
    {
        $user = $request->user();
        $user->load('personne');
        $id = $user->personne_id;
        $congesResponsable = Conge::select('*')
            ->join('personnes', 'personnes.id', '=', 'conges.personne_id')
            ->where('personnes.chef_id', $id)->orWhere('personnes.id', $id)->with('DemandeConge')
            ->get();
        return response()->json(["Conges" => $congesResponsable]);
    }
    public function absenceDirecteur(Request $request)
    {
        $user = $request->user();
        $user->load('personne.etablissement');
        $idE = $user->personne->etablissement_id;
        $idP = $user->personne->id;
        $absenceDirecteur = Absence::select('*')
            ->join('personnes', 'personnes.id', '=', 'absences.personne_id')
            ->where('personnes.etablissement_id', $idE)->orWhere('personnes.id', $idP)->with('DemandeAbsence')
            ->get();

        return response()->json(["Absences" => $absenceDirecteur]);
    }
    public function congeDirecteur(Request $request)
    {
        $user = $request->user();
        $user->load('personne.etablissement');
        $idE = $user->personne->etablissement_id;
        $idP = $user->personne->id;
        $congeDirecteur = Conge::select('*')
            ->join('personnes', 'personnes.id', '=', 'conges.personne_id')
            ->where('personnes.etablissement_id', $idE)->orWhere('personnes.id', $idP)->with('DemandeConge')
            ->get();
        return response()->json(["Conges" => $congeDirecteur]);
    }
    public function demandeConge(Request $request)
    {
        $user = $request->user();
        $user->load('personne');
        $id = $user->personne->id;
        $Conge = DemandeConge::where('personne_id', $id)->get();
        return response()->json(["DemandeConge" => $Conge]);
    }
    public function demandeAbsence(Request $request)
    {
        $user = $request->user();
        $user->load('personne');
        $id = $user->personne->id;
        $Absence = DemandeAbsence::where('personne_id', $id)->get();
        return response()->json(["DemandeAbsence" => $Absence]);
    }
    public function demandeAbsenceResponsable(Request $request)
    {
        $user = $request->user();
        $user->load('personne');
        $r = $user->personne->role;
        if ($r === "Superviseur") {
            $id = $user->personne_id;
            $demandeAbsencesResponsable = DemandeAbsence::select('*')
                ->join('personnes', 'personnes.id', '=', 'demande_absences.personne_id')
                ->where('personnes.chef_id', $id)->orWhere('personnes.id', $id)
                ->get();
            return response()->json(["DemandeAbsence" => $demandeAbsencesResponsable]);
        }
        return false;
    }
    public function demandeCongeResponsable(Request $request)
    {
        $user = $request->user();
        $user->load('personne');
        $r = $user->personne->role;
        if ($r === "Superviseur") {
            $id = $user->personne_id;
            $demandeCongeResponsable = DemandeConge::select('*')
                ->join('personnes', 'personnes.id', '=', 'demande_conges.personne_id')
                ->where('personnes.chef_id', $id)->orWhere('personnes.id', $id)
                ->get();
            return response()->json(["DemandeConge" => $demandeCongeResponsable]);
        }
        return false;
    }
    public function Employes(Request $request)
    {
        $user = $request->user();
        $user->load('personne');
        $r = $user->personne->role;
        if ($r === "Superviseur") {
            $id = $user->personne_id;
            $Personnes = Personne::select('*')
                ->where('personnes.chef_id', $id)->with('fonction', 'grade', 'service', 'echelle', 'chef', 'etablissement')
                ->get();
            return response()->json(["Personnes" => $Personnes]);
        } elseif ($r === "Directeur") {
            $user->load('personne.etablissement');
            $idE = $user->personne->etablissement_id;
            $Personnes = Personne::select('*')
                ->where('personnes.etablissement_id', $idE)->with('fonction', 'grade', 'service', 'echelle', 'chef', 'etablissement')
                ->get();
            return response()->json(["Personnes" => $Personnes]);
        }
        return false;
    }
}
