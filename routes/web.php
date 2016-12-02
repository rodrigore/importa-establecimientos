<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('import', function () {
    //
    Excel::load('storage/app/public/establecimientos.xlsx', function ($reader) {
        $sheet = $reader->get()->first();
        $sheet->each(function ($row) {
            \App\Establecimiento::create([
                'code' => (int)$row->codigo_nuevo_establecimiento,
                'name' => $row->nombre_oficial,
                'comuna_id' => $row->codigo_comuna
            ]);
        });
    });

    return \App\Establecimiento::limit(2)->toArray();

    // import to another database
    /* DB::connection('pgsql_import')-> */
});

Route::get('view', function () {
    \Log::info(print_r(\App\Establecimiento::select('name', 'code', 'comuna_id')->get()->toArray(), true));
});
