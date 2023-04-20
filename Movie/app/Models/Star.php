<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class Star extends Model
{
    protected $table='star';
    
    public function movies()
    {
        return $this->belongsTo('App\Models\Movie','movie_id','id');
    }
}
