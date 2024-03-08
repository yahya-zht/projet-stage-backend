<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;
    protected $fillable = ['date_demande', 'date_debut', 'date_fin', 'état', 'personne_id', 'conge_id'];
    public function Conge()
    {
        return $this->belongsTo(Conge::class);
    }
    public function Personne()
    {
        return $this->belongsTo(Personne::class);
    }
}
