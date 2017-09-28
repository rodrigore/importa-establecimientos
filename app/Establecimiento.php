<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Establecimiento extends Model
{
    protected $fillable = [
        'nombre',
        'codigo',
        'dependencia',
        'comuna_id',
    ];
}
