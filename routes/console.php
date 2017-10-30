<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('importa', function () {
    $this->comment('Importando ...');
    \App\Establecimiento::truncate();
    Excel::load('storage/app/public/establecimientos.xlsx', function ($reader) {
        $sheet = $reader->get()->first();
        $sheet->each(function ($row) {
            if ($row->nombre_oficial) {
                \App\Establecimiento::create([
                    'codigo' => (int)$row->codigo_nuevo_establecimiento,
                    'nombre' => $row->nombre_oficial,
                    'dependencia' => $row->dependencia,
                    'comuna_id' => $row->codigo_comuna
                ]);
            }
        });
    });
    $this->comment('Fin.');
})->describe('Importa establecimientos');

Artisan::command('importa:unidades', function () {
    $this->comment('Importando unidades ...');
    Excel::load('storage/app/public/unidades.xlsx', function ($reader) {
        $sheet = $reader->get()->first();
        $sheet->each(function ($row) {
            if ($row->nombre) {
                $servicioNombre = trim(str_replace('Servicio de Salud', '', $row->servicio_de_salud));

                App\UnidadAdministrativa::create([
                    'nombre' => $row->nombre,
                    'dependencia' => $row->dependencia,
                    'comuna_id' => DB::table('comunas')->whereCodigo($row->codigo_comuna)->first()->id,
                    'servicio_id' => DB::table('servicios')->whereNombre($servicioNombre)->first()->id,
                ]);
            }
        });
    });
    $this->comment('Fin.');
})->describe('Importa unidades administrativas');
