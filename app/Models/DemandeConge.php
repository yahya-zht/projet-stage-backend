<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeConge extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = ['dataDemande', 'dataDebut', 'dataFin', 'état', 'personne_id', 'conge_id'];
    public function Conge()
    {
        return $this->belongsTo(Conge::class);
    }
    public function Personne()
    {
        return $this->belongsTo(Personne::class);
    }
}
