<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Espisode extends Model
{
    protected $table='espisode';

    public function movie()
    {
        return $this->belongsTo('App\Models\Movie','movie_id','id');
    }
}
