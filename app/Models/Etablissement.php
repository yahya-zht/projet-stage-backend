<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etablissement extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'adresse', 'directeur_id'];
    public function Personne()
    {
        return $this->belongsTo(Personne::class);
    }
    public function Service()
    {
        return $this->belongsToMany(Service::class, 'etablissement_service', 'etablissement_id', 'service_id');
    }
}
