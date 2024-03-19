<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;
    protected $fillable = ['date_debut', 'date_fin', 'type', 'duree', 'personne_id', 'certificatMedical_id', 'demande_absence_id'];
    public function Personne()
    {
        return $this->belongsTo(Personne::class);
    }
    public function DemandeAbsence()
    {
        return $this->belongsTo(DemandeAbsence::class);
    }
    public function CertificatMedical()
    {
        return $this->belongsTo(CertificatMedical::class);
    }
}
