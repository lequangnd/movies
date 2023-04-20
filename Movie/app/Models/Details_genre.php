<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Details_genre extends Model
{
    protected $table='details_genres';
    public function genres()
    {
        return $this->belongsTo('App\Models\Genre','genre_id','id');
    }

    public function movies()
    {
        return $this->belongsTo('App\Models\Movie','movie_id','id');
    }
}
