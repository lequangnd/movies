<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $table = 'genres';
    
    public function details_genres()
    {
        return $this->hasMany('App\Models\Details_genre','genre_id','id');
    }
}
