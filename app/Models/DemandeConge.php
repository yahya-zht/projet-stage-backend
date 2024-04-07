<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeConge extends Model
{
    use HasFactory;
    protected $fillable = ['Ref', 'dateDemande', 'dateDebut', 'dateFin', 'état', 'personne_id', 'type', 'duree'];
    public function Conge()
    {
        return $this->belongsTo(Conge::class);
    }
    public function Personne()
    {
        return $this->belongsTo(Personne::class);
    }
}
