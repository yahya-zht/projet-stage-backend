<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeAbsence extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = ['dateDemande', 'dateDebut', 'dateFin', 'état', 'personne_id'];
    public function Absence()
    {
        return $this->belongsTo(Absence::class);
    }
    public function Personne()
    {
        return $this->belongsTo(Personne::class);
    }
}
