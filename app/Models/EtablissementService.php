<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtablissementService extends Model
{
    protected $table = 'etablissements_services';
    protected $fillable = ['etablissement_id', 'service_id', 'nombre_employes'];
    use HasFactory;
    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'etablissements_services');
    }

    public function service()
    {
        return $this->belongsToMany(Service::class, 'etablissements_services');
    }
}
