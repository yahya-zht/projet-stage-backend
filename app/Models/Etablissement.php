<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etablissement extends Model
{
    use HasFactory;
    public function services()
    {
        return $this->belongsToMany(Service::class, 'etablissement_service', 'etablissement_id', 'service_id');
    }
}
