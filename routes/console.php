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
