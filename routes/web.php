<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('view', function () {
    return print_r(\App\Establecimiento::select('name', 'code', 'comuna_id')->get()->toArray(), true);
    \Log::info(print_r(\App\Establecimiento::select('name', 'code', 'comuna_id')->get()->toArray(), true));
});
