<?php
Route::link("/setup","Setup@index");
Route::post("submit","Setup@submit");
Route::get("table_delete","Setup@tableDelete");
Route::post("setup_key","Setup@login");