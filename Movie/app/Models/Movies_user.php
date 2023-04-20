<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movies_user extends Model
{
    protected $table='movies_user';

    public function movies()
    {
        return $this->belongsTo('App\Models\Movie','movie_id','id');
    }

    public function comment()
    {
        return $this->hasMany('App\Models\Comment','movie_id','movie_id');
    }

    public function details_genre()
    {
        return $this->hasMany('App\Models\Details_genre','movie_id','movie_id');
    }

}
