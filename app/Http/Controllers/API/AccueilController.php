<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Conge;
use App\Models\DemandeAbsence;
use App\Models\DemandeConge;
use App\Models\Etablissement;
use App\Models\EtablissementService;
use App\Models\Personne;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccueilController extends Controller
{
    public function employee(Request $request)
    {
        $user = $request->user();
        $id = $user->personne_id;

        $NbConges = Personne::select('personnes.solde_congés', DB::raw('SUM(conges.duree) as SUMDayInYear'))
            ->join('conges', 'personnes.id', '=', 'conges.personne_id')
            ->whereYear('conges.date_debut', now()->year)
            ->where('personnes.id', $id)
            ->groupBy('personnes.solde_congés')
            ->get();
        $NbAbsence = Absence::whereYear('date_debut', now()->year)
            ->where('personne_id', $id)
            ->sum('duree');
        $AllAbsinMonth = [];
        for ($month = 1; $month <= 12; $month++) {
            $result
                = (int) Absence::whereYear('date_debut', now()->year)
                    ->whereMonth('date_debut', $month)
                    ->where('personne_id', $id)
                    ->sum('duree');
            $AllAbsinMonth[] = $result;
        }
        $AllCongesinMonth = [];
        for ($month = 1; $month <= 12; $month++) {
            $result
                = (int) Conge::whereYear('date_debut', now()->year)
                    ->whereMonth('date_debut', $month)
                    ->where('personne_id', $id)
                    ->sum('duree');
            $AllCongesinMonth[] = $result;
        }
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;


        $demandeAbsencesCeMois = DemandeAbsence::join('personnes as p', 'p.id', '=', 'demande_absences.personne_id')
            ->whereYear('demande_absences.dateDemande', $currentYear)
            ->whereMonth('demande_absences.dateDemande', $currentMonth)
            ->where('personne_id', $id)->select('*', 'demande_absences.id as idA')
            ->get();
        $demandeCongesCeMois = DemandeConge::join('personnes as p', 'p.id', '=', 'demande_conges.personne_id')
            ->whereYear('demande_conges.dateDemande', $currentYear)
            ->whereMonth('demande_conges.dateDemande', $currentMonth)
            ->where('personne_id', $id)->select('*', 'demande_conges.id as idC')
            ->get();
        return response()->json([
            "Conges" => $NbConges,
            "NbAbsence" => $NbAbsence,
            "AllAbsinMonth" => $AllAbsinMonth,
            "AllCongesinMonth" => $AllCongesinMonth,
            'demandeCongesCeMois' => $demandeCongesCeMois,
            'demandeAbsencesCeMois' => $demandeAbsencesCeMois,
        ]);
    }
    public function Directeur(Request $request)
    {
        $user = $request->user();
        $user->load('personne.etablissement');
        $IdET = $user->personne->etablissement_id;
        $personnesCount = Personne::where('etablissement_id', $IdET)->count();

        $servicesCount = EtablissementService::where('etablissement_id', $IdET)->count();
        $currentDate = now()->toDateString();

        $absencesTodayCount = Absence::join('personnes as p', 'p.id', '=', 'absences.personne_id')
            ->where('p.etablissement_id', $IdET)
            ->whereDate('absences.date_debut', '<=', $currentDate)
            ->whereDate('absences.date_fin', '>=', $currentDate)
            ->count();

        $congesTodayCount = Conge::join('personnes as p', 'p.id', '=', 'conges.personne_id')
            ->where('p.etablissement_id', $IdET)
            ->whereDate('conges.date_debut', '<=', $currentDate)
            ->whereDate('conges.date_fin', '>=', $currentDate)
            ->count();

        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;


        $congesCurrentMonthCount = Conge::join('personnes as p', 'p.id', '=', 'conges.personne_id')
            ->where('p.etablissement_id', $IdET)
            ->whereYear('conges.date_debut', $currentYear)
            ->whereMonth('conges.date_debut', $currentMonth)
            ->orWhereYear('conges.date_fin', $currentYear)
            ->whereMonth('conges.date_fin', $currentMonth)
            ->count();

        $absencesCurrentMonthCount = Absence::join('personnes as p', 'p.id', '=', 'absences.personne_id')
            ->where('p.etablissement_id', $IdET)
            ->whereYear('absences.date_debut', $currentYear)
            ->whereMonth('absences.date_debut', $currentMonth)
            ->orWhereYear('absences.date_fin', $currentYear)
            ->whereMonth('absences.date_fin', $currentMonth)
            ->count();

        $demandeAbsencesCount = DemandeAbsence::join('personnes as p', 'p.id', '=', 'demande_absences.personne_id')
            ->where('p.etablissement_id', $IdET)
            ->whereYear('demande_absences.dateDemande', $currentYear)
            ->whereMonth('demande_absences.dateDemande', $currentMonth)
            ->where('demande_absences.état', 'En Attendant')
            ->count();

        $demandeCongesCount = DemandeConge::join('personnes as p', 'p.id', '=', 'demande_conges.personne_id')
            ->where('p.etablissement_id', $IdET)
            ->whereYear('demande_conges.dateDemande', $currentYear)
            ->whereMonth('demande_conges.dateDemande', $currentMonth)
            ->where('demande_conges.état', 'En Attendant')
            ->count();

        $demandeAbsencesTodayCount = DemandeAbsence::join('personnes as p', 'p.id', '=', 'demande_absences.personne_id')
            ->where('p.etablissement_id', $IdET)
            ->whereDate('demande_absences.dateDemande', Carbon::today())
            ->where('demande_absences.état', 'En Attendant')
            ->count();

        $demandeCongesTodayCount = DemandeConge::join('personnes as p', 'p.id', '=', 'demande_conges.personne_id')
            ->where('p.etablissement_id', $IdET)
            ->whereDate('demande_conges.dateDemande', Carbon::today())
            ->where('demande_conges.état', 'En Attendant')
            ->count();

        $totalDemandeAbsencesCount = DemandeAbsence::join('personnes as p', 'p.id', '=', 'demande_absences.personne_id')
            ->where('p.etablissement_id', $IdET)
            ->where('demande_absences.état', 'En Attendant')
            ->count();

        $totalDemandeCongesCount = DemandeConge::join('personnes as p', 'p.id', '=', 'demande_conges.personne_id')
            ->where('p.etablissement_id', $IdET)
            ->where('demande_conges.état', 'En Attendant')
            ->count();

        $currentYear = now()->year;
        $congesCounts = [];
        for ($month = 1; $month <= 12; $month++) {
            $congesCounts[] = Conge::join('personnes as p', 'p.id', '=', 'conges.personne_id')
                ->where('p.etablissement_id', $IdET)
                ->whereYear('conges.date_debut', $currentYear)
                ->whereMonth('conges.date_debut', $month)
                ->count();
        }

        $absencesCounts = [];
        for ($month = 1; $month <= 12; $month++) {
            $absencesCounts[] = Absence::join('personnes as p', 'p.id', '=', 'absences.personne_id')
                ->where('p.etablissement_id', $IdET)
                ->whereYear('absences.date_debut', $currentYear)
                ->whereMonth('absences.date_debut', $month)->count();
        }

        $congesToday = Conge::join('personnes as p', 'p.id', '=', 'conges.personne_id')
            ->where('p.etablissement_id', $IdET)
            ->whereDate('conges.date_debut', '<=', $currentDate)
            ->whereDate('conges.date_fin', '>=', $currentDate)->with('DemandeConge')
            ->get();


        $absencesToday = Absence::join('personnes as p', 'p.id', '=', 'absences.personne_id')
            ->where('p.etablissement_id', $IdET)
            ->whereDate('absences.date_debut', '<=', $currentDate)
            ->whereDate('absences.date_fin', '>=', $currentDate)->with('DemandeAbsence')
            ->get();

        $demandeAbsencesToday = DemandeAbsence::join('personnes as p', 'p.id', '=', 'demande_absences.personne_id')
            ->where('p.etablissement_id', $IdET)
            ->whereDate('demande_absences.dateDemande', $currentDate)
            ->where('demande_absences.état', 'En Attendant')->select('*', 'demande_absences.id as idA')
            ->get();
        $demandeCongesToday = DemandeConge::join('personnes as p', 'p.id', '=', 'demande_conges.personne_id')
            ->where('p.etablissement_id', $IdET)
            ->whereDate('demande_conges.dateDemande', $currentDate)
            ->where('demande_conges.état', 'En Attendant')->select('*', 'demande_conges.id as idC')
            ->get();
        return response()->json([
            'personnes_count' => $personnesCount,
            'services_count' => $servicesCount,
            'absences_today_count' => $absencesTodayCount,
            'conges_today_count' => $congesTodayCount,
            'conges_current_month_count' => $congesCurrentMonthCount,
            'absences_current_month_count' => $absencesCurrentMonthCount,
            'demande_absences_count' => $demandeAbsencesCount,
            'demande_conges_count' => $demandeCongesCount,
            'demande_absences_today_count' => $demandeAbsencesTodayCount,
            'demande_conges_today_count' => $demandeCongesTodayCount,
            'total_demande_absences_count' => $totalDemandeAbsencesCount,
            'total_demande_conges_count' => $totalDemandeCongesCount,
            'conges_cette_année' => $congesCounts,
            'absence_cette_année' => $absencesCounts,
            'conges_today' => $congesToday,
            'absences_today' => $absencesToday,
            'demande_absences_today' => $demandeAbsencesToday,
            'demande_conges_today' => $demandeCongesToday,
        ]);
    }
    public function Admin(Request $request)
    {
        $user = $request->user();
        $user->load('personne');
        $role = $user->role;
        // if ($role === 'admin') {

        // $user->load('personne.etablissement');
        // $IdET = $user->personne->etablissement_id;
        $personnesCount = Personne::count();

        $servicesCount = Service::count();
        $etablissementsCount = Etablissement::count();
        $currentDate = now()->toDateString();
        $absencesTodayCount = Absence::whereDate('absences.date_debut', '<=', $currentDate)
            ->whereDate('absences.date_fin', '>=', $currentDate)
            ->count();

        $congesTodayCount = Conge::whereDate('conges.date_debut', '<=', $currentDate)
            ->whereDate('conges.date_fin', '>=', $currentDate)
            ->count();

        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;


        $congesCurrentMonthCount = Conge::whereYear('conges.date_debut', $currentYear)
            ->whereMonth('conges.date_debut', $currentMonth)
            ->orWhereYear('conges.date_fin', $currentYear)
            ->whereMonth('conges.date_fin', $currentMonth)
            ->count();

        $absencesCurrentMonthCount = Absence::whereYear('absences.date_debut', $currentYear)
            ->whereMonth('absences.date_debut', $currentMonth)
            ->orWhereYear('absences.date_fin', $currentYear)
            ->whereMonth('absences.date_fin', $currentMonth)
            ->count();

        $demandeAbsencesCount = DemandeAbsence::whereYear('dateDemande', $currentYear)
            ->whereMonth('dateDemande', $currentMonth)
            ->count();

        $demandeCongesCount = DemandeConge::whereYear('demande_conges.dateDemande', $currentYear)
            ->whereMonth('demande_conges.dateDemande', $currentMonth)
            ->count();

        $demandeAbsencesCountCetteAnnée = DemandeAbsence::whereYear('dateDemande', $currentYear)
            ->count();

        $demandeCongesCountCetteAnnée = DemandeConge::whereYear('demande_conges.dateDemande', $currentYear)
            ->count();

        $demandeAbsencesTodayCount = DemandeAbsence::whereDate('demande_absences.dateDemande', Carbon::today())
            ->count();

        $demandeCongesTodayCount = DemandeConge::whereDate('demande_conges.dateDemande', Carbon::today())
            ->count();

        $totalDemandeAbsencesCount = DemandeAbsence::where('demande_absences.état', 'En Attendant')->count();

        $totalDemandeCongesCount = DemandeConge::where('demande_conges.état', 'En Attendant')->count();

        $currentYear = now()->year;
        $congesCounts = [];
        for ($month = 1; $month <= 12; $month++) {
            $congesCounts[] = Conge::whereYear('conges.date_debut', $currentYear)
                ->whereMonth('conges.date_debut', $month)
                ->count();
        }

        $absencesCounts = [];
        for ($month = 1; $month <= 12; $month++) {
            $absencesCounts[] = Absence::whereYear('absences.date_debut', $currentYear)
                ->whereMonth('absences.date_debut', $month)->count();
        }

        $congesToday = Conge::join('personnes as p', 'p.id', '=', 'conges.personne_id')
            ->whereDate('conges.date_debut', '<=', $currentDate)
            ->whereDate('conges.date_fin', '>=', $currentDate)->with('DemandeConge')
            ->get();


        $absencesToday = Absence::join('personnes as p', 'p.id', '=', 'absences.personne_id')
            ->whereDate('absences.date_debut', '<=', $currentDate)
            ->whereDate('absences.date_fin', '>=', $currentDate)->with('DemandeAbsence')
            ->get();

        $demandeAbsencesToday = DemandeAbsence::join('personnes as p', 'p.id', '=', 'demande_absences.personne_id')
            ->whereDate('demande_absences.dateDemande', $currentDate)
            ->where('demande_absences.état', 'En Attendant')->select('*', 'demande_absences.id as idA')
            ->get();
        $demandeCongesToday = DemandeConge::join('personnes as p', 'p.id', '=', 'demande_conges.personne_id')
            ->whereDate('demande_conges.dateDemande', $currentDate)
            ->where('demande_conges.état', 'En Attendant')->select('*', 'demande_conges.id as idC')
            ->get();
        return response()->json([
            'personnes_count' => $personnesCount,
            'services_count' => $servicesCount,
            'etablissements_count' => $etablissementsCount,
            'absences_today_count' => $absencesTodayCount,
            'conges_today_count' => $congesTodayCount,
            'conges_current_month_count' => $congesCurrentMonthCount,
            'absences_current_month_count' => $absencesCurrentMonthCount,
            'demande_absences_count' => $demandeAbsencesCount,
            'demande_conges_count' => $demandeCongesCount,
            'demande_absences_today_count' => $demandeAbsencesTodayCount,
            'demande_conges_today_count' => $demandeCongesTodayCount,
            'demandeCongesCountCetteAnnée' => $demandeCongesCountCetteAnnée,
            'demandeAbsencesCountCetteAnnée' => $demandeAbsencesCountCetteAnnée,
            'total_demande_absences_count' => $totalDemandeAbsencesCount,
            'total_demande_conges_count' => $totalDemandeCongesCount,
            'conges_cette_année' => $congesCounts,
            'absence_cette_année' => $absencesCounts,
            'conges_today' => $congesToday,
            'absences_today' => $absencesToday,
            'demande_absences_today' => $demandeAbsencesToday,
            'demande_conges_today' => $demandeCongesToday,
        ]);
        // } else {
        //     return response()->json([
        //         'message' => 'Vous n\'avez pas le droit d\'accéder à cette page'
        //     ], 403);
        // }
    }
}
