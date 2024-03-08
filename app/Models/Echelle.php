<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Echelle extends Model
{
    use HasFactory;
    protected $fillable = ['libelle', 'niveau'];
    public function Personne()
    {
        return $this->hasMany(Personne::class);
    }
}
