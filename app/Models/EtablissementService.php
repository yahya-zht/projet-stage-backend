<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtablissementService extends Model
{
    protected $table = 'etablissements_services';
    use HasFactory;
    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
