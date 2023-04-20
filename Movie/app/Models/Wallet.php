<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class Wallet extends Model
{
    protected $table='wallet';

    public function social()
    {
        return $this->belongsTo('App\Models\Social','provider_id','provider_id');
    }

    public function users()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
