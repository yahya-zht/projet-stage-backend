<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personne extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'CIN', 'prenom', 'date_naissance', 'adresse', 'telephone', 'role', 'chef_id', 'grade_id', 'fonction_id', 'echelle_id', 'service_id'];
    public function Absence()
    {
        return $this->hasMany(Absence::class);
    }
    public function Echelle()
    {
        return $this->belongsTo(Echelle::class);
    }
    public function Service()
    {
        return $this->belongsTo(Service::class);
    }
    public function Etablissement()
    {
        return $this->belongsTo(Etablissement::class);
    }
    public function Fonction()
    {
        return $this->belongsTo(Fonction::class);
    }
    public function Grade()
    {
        return $this->belongsTo(Grade::class);
    }
    public function DemandeAbsence()
    {
        return $this->hasMany(DemandeAbsence::class);
    }
    public function DemandeConge()
    {
        return $this->hasMany(DemandeConge::class);
    }
    public function Chef()
    {
        return $this->belongsTo(Personne::class);
    }
    public function Employe()
    {
        return $this->hasMany(Personne::class);
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
