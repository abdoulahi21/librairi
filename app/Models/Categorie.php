<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function books()
    {
        return $this->hasMany(Book::class);  // Chaque catégorie peut avoir plusieurs livres
    }
}
