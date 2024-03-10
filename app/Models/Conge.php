<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conge extends Model
{
    use HasFactory;
    protected $fillable = ['date_debut', 'date_fin', 'duree', 'type', 'personne_id'];
    public function Personne()
    {
        return $this->belongsTo(Personne::class);
    }
    public function DemandeConge()
    {
        return $this->belongsTo(DemandeConge::class);
    }
}
