<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;
    protected $fillable = ['date_debut', 'date_fin', 'type', 'duree', 'personne_id'];
    public function Personne()
    {
        return $this->belongsTo(Personne::class);
    }
}
