<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    protected $fillable = ['libelle', 'salaire'];
    public function Personne()
    {
        return $this->hasMany(Personne::class);
    }
}
