<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conge extends Model
{
    use HasFactory;
    protected $fillable = ['date_debut', 'date_fin', 'duree', 'type'];
    public function Demande()
    {
        return $this->belongsTo(Demande::class);
    }
}
