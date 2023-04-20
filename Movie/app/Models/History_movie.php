<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History_movie extends Model
{
    protected $table='history_movies';
    public function movies()
    {
        return $this->belongsTo('App\Models\Movie','movie_id','id');
    }
}
