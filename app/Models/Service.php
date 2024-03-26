<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'responsable_id', 'nombre_employes'];
    public function Etablissement()
    {
        return $this->belongsToMany(Etablissement::class, 'etablissements_services');
    }
    public function Employees()
    {
        return $this->hasMany(Personne::class);
    }
    public function Responsable()
    {
        return $this->belongsTo(Personne::class, 'responsable_id');
    }
}
