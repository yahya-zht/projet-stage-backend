<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    protected $fillable = ['date_debut', 'date_fin', 'duree', 'type'];
    public function Personne()
    {
        return $this->hasMany(Personne::class);
    }
}
