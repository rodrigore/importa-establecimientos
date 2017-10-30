<?php

namespace App;

use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnidadAdministrativa extends Model
{
    protected $table = 'unidades_administrativas';

    protected $fillable = [
        'nombre',
        'dependencia',
        'comuna_id',
        'servicio_id'
    ];

    public function comuna()
    {
        return $this->belongsTo(Comuna::class);
    }

    public function servicio()
    {
        return $this->belongsTo(ServicioSalud::class);
    }
}

