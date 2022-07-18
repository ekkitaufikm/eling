<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\ProdukHukum;
use App\JenisProdukHukum;
use App\StatusProduk;
use App\Satker;
use App\Notifikasi;
use DB;


class LaporanController extends Controller
{

  public function get_jumlah_produk($tab, $satker, $parameter)
  {
    if ($tab == 'status') {
      $data = ProdukHukum::where('produk_hukum.tahun', '=', Session::get('yearactive'));
      if ($satker != 'all') {
        $data = $data->where('produk_hukum.fid_satker', '=', $satker);
      }
      if ($parameter != 'all') {
        $data = $data->where('produk_hukum.fid_status', '=', $parameter);
      }
      $data = $data->count();
      return $data;
    } elseif ($tab == 'jenis') {
      $data = ProdukHukum::where('produk_hukum.tahun', '=', Session::get('yearactive'));
      if ($satker != 'all') {
        $data = $data->where('produk_hukum.fid_satker', '=', $satker);
      }
      if ($parameter != 'all') {
        $data = $data->where('produk_hukum.fid_jenis_produk_hukum', '=', $parameter);
      }
      $data = $data->count();
      return $data;
    }
  }

  public function index(Request $request)
  {
    if (!empty($request->tab)) {
      $tab = $request->tab;
    } else {
      $tab = 'jenis';
    }

    $data['satker'] = Satker::where('publish', '1')->orderBy('kode_satker')->get();
    foreach ($data['satker'] as $key => $value) {
      if ($tab == 'status') {
        $status = StatusProduk::get();
        foreach ($status as $key2 => $value2) {
          $status[$key2]->jumlah = $this->get_jumlah_produk('status', $value->id, $value2->id);
        }
        $data['satker'][$key]->status = $status;
      }

      if ($tab == 'jenis') {
        $jenis = JenisProdukHukum::get();
        foreach ($jenis as $key2 => $value2) {
          $jenis[$key2]->jumlah = $this->get_jumlah_produk('jenis', $value->id, $value2->id);
        }
        $data['satker'][$key]->jenis = $jenis;
      }
      $data['satker'][$key]->jumlah = $this->get_jumlah_produk('status', $value->id, 'all');
    }

    //Jumlah Produk Hukum Berdasarkan Status
    $data['rekap-status-jumlah'] = StatusProduk::get();
    foreach ($data['rekap-status-jumlah'] as $key => $value) {
      $data['rekap-status-jumlah'][$key]->jumlah = $this->get_jumlah_produk('status', 'all', $value->id);
    }

    //Jumlah Produk Hukum Berdasarkan Jenis
    $data['rekap-jenis-jumlah'] = JenisProdukHukum::get();
    foreach ($data['rekap-jenis-jumlah'] as $key => $value) {
      $data['rekap-jenis-jumlah'][$key]->jumlah = $this->get_jumlah_produk('jenis', 'all', $value->id);
    }

    $data['jumlah-produk-status'] = $this->get_jumlah_produk('status', 'all', 'all');
    $data['jumlah-produk-jenis'] = $this->get_jumlah_produk('jenis', 'all', 'all');

    $master['status-produk'] = StatusProduk::get();
    $master['klasifikasi'] = JenisProdukHukum::get();

    return view('laporan.index')
      ->with('tab', $tab)
      ->with('master', $master)
      ->with('data', $data);
  }

  public function notifikasi()
  {
    $data['notifikasi'] = Notifikasi::select('notifikasi.*', 'users.nama as nama_lengkap')
      ->join('users', 'users.id', '=', 'notifikasi.tujuan')
      ->where('tujuan', Session::get('useractive')->id)
      ->orderBy('tanggal', 'DESC')
      ->get();
    return view('notifikasi')
      ->with('data', $data);
  }
}