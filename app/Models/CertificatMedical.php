<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificatMedical extends Model
{
    protected $table = 'certificat_medical';

    use HasFactory;
    protected $fillable = ['dateDebut', 'dateFin', 'medecin', 'diagnostic', 'dateEmission', 'validite', 'etablissement', 'absence_id'];
    public function Absence()
    {
        return $this->hasOne(Absence::class);
    }
}
