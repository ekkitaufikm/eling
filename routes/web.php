<?php
Route::get('storage/{folder}/{filename}', function ($folder, $filename) {
  $path = storage_path('app/' . $folder . '/' . $filename);
  if (!File::exists($path)) {
    abort(404);
  }
  $file = File::get($path);
  $type = File::mimeType($path);
  $response = Response::make($file, 200);
  $response->header("Content-Type", $type);
  return $response;
});

Route::get('/', 'DashboardController@landingPage');
Route::post('login', 'AuthController@login');
Route::get('login', 'AuthController@index');

Route::get('send_wa/{tujuan}', 'DashboardController@send_wa');

Route::group(['middleware' => ['ceklogin']], function () {

  Route::get('dashboard', 'DashboardController@index');

  //Master - User
  Route::post('master/user/proses/{action?}', 'MasterController@prosesUser');
  Route::get('master/user', 'MasterController@userTampil');
  Route::post('ubah-password/{id}', 'MasterController@ubahPassword');
  Route::post('ubah-tahun', 'MasterController@ubahTahun');

  //Master - Satker
  Route::post('master/satker/proses/{action?}', 'MasterController@prosesSatker');
  Route::get('master/satker', 'MasterController@satkerTampil');
  Route::get('master/satker/update_status/{id}/{status}', 'MasterController@update_statusSatker');

  Route::get('master/setting-status', 'MasterController@statusTampil');
  Route::post('master/setting-status/proses/{jenis}', 'MasterController@proses_status');

  Route::get('master/setting-dashboard', 'MasterController@settingDashboard');
  Route::post('master/save-dashboard', 'MasterController@saveDashboard');

  //Master - Data Kinerja
  Route::post('master/kinerja/proses/{action?}', 'MasterController@prosesKinerja');
  Route::get('master/kinerja/{search?}/{page?}', 'MasterController@kinerjaTampil');

  //master - slider
  Route::get('master/slider','MasterController@slideshowTampil');
  Route::post('master/slider/proses/{action?}','MasterController@proses_slideshow');
  Route::get('master/slider/update_status/{id}','MasterController@update_statusslideshow');
  
  //Master - Informasi
  Route::get('master/info','MasterController@infoTampil');
  Route::post('master/info/proses/{action?}','MasterController@proses_info');
  Route::get('master/info/update_status/{id}','MasterController@update_statusinfo');


  //Usulan
  Route::get('usulan', 'UsulanController@index');
  //Route::get('usulan/test', 'UsulanController@test');
  Route::get('usulan/hapus','UsulanController@list_hapus');
  Route::get('usulan/form', 'UsulanController@form');
  Route::get('usulan/detail', 'UsulanController@detail');
  Route::post('usulan/produk/proses', 'UsulanController@proses_produk');
  Route::post('usulan/lampiran/proses', 'UsulanController@proses_lampiran');
  Route::post('usulan/kendali/proses', 'UsulanController@proses_kendali');
  Route::post('usulan/file-upload','UsulanController@file_upload');

  //Produk Hukum
  Route::get('produk', 'ProdukController@index');
  Route::get('produk/detil', 'ProdukController@detil');
  Route::get('produk/cetak_register', 'ProdukController@cetak_register');
  Route::post('produk/register/proses', 'ProdukController@proses_register');
  Route::post('produk/tracking/proses', 'ProdukController@proses_tracking');
  Route::get('laporan', 'LaporanController@index');

  Route::get('notifikasi', 'LaporanController@notifikasi');

  Route::get('display', 'DashboardController@display');

  Route::get('logout', 'AuthController@logoutProses');
});