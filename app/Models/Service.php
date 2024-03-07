<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    public function etablissements()
    {
        return $this->belongsToMany(Etablissement::class, 'etablissement_service', 'service_id', 'etablissement_id');
    }
}
