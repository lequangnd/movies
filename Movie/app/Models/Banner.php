<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table='banner';
    public function movies()
    {
        return $this->belongsTo('App\Models\Movie','movie_id','id');
    }
}
