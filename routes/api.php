<?php
Route::get('user/{id?}','ApiController@getUser');
Route::get('satker/{id}','ApiController@getSatker');
Route::get('kinerja/{id}','ApiController@getKinerja');
Route::get('satker_modal','ApiController@satkerModal');
Route::get('slider/{id}','ApiController@sliderModal');
Route::get('info/{id}','ApiController@infoModal');
