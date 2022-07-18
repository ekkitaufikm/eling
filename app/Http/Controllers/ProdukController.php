<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\ProdukHukum;
use App\UsulanProdukHukum;
use App\StatusProduk;
use App\Klasifikasi;
use App\JenisKendali;
use App\KendaliUsulan;
use App\KendaliStatus;
use App\JenisProdukHukum;
use App\User;
use App\Satker;
use App\Lampiran;
use App\JenisTracking;
use App\KendaliTracking;
use DB;

class ProdukController extends Controller
{
  public function dateFormat($date, $format)
  {
    $date = date_create($date);
    $date_new = date_format($date, $format);
    return $date_new;
  }

  public function index(Request $request)
  {
    if (!empty($request->search)) {
      $search = $request->search;
    } else {
      $search = NULL;
    }

    if (!empty($request->satker)) {
      $satker = $request->satker;
    } else {
      $satker = 'all';
    }


    $query = ProdukHukum::select('produk_hukum.*', 'satuan_kerja.nama as satker', 'status_produk.status_produk', 'status_produk.label', 'jenis_produk_hukum.jenis_produk_hukum', 'pejabat_penetap.pejabat_penetap')
      ->Leftjoin('satuan_kerja', 'satuan_kerja.id', '=', 'produk_hukum.fid_satker')
      ->Leftjoin('status_produk', 'status_produk.id', '=', 'produk_hukum.fid_status')
      ->Leftjoin('jenis_produk_hukum', 'jenis_produk_hukum.id', '=', 'produk_hukum.fid_jenis_produk_hukum')
      ->Leftjoin('pejabat_penetap', 'pejabat_penetap.id', '=', 'produk_hukum.pejabat_penetap')
      ->where('produk_hukum.tahun', '=', Session::get('yearactive'))
      ->where('produk_hukum.fid_status', '=', 9)
      ->orderBy('produk_hukum.tanggal_usulan', 'DESC');

    if (Session::get('useractive')->hak_akses == 5) {
      $query = $query->where('produk_hukum.fid_satker', '=', Session::get('useractive')->fid_satker);
    } elseif (Session::get('useractive')->hak_akses == 4) {
      $query = $query->Leftjoin('kendali_usulan', 'kendali_usulan.fid_produk_hukum', '=', 'produk_hukum.id')
        ->where('kendali_usulan.fid_tujuan', '=', Session::get('useractive')->id)
        ->groupBy('produk_hukum.id');
    }

    $data['produk'] = $query->get();

    return view('produk.index')
      ->with('search', $search)
      ->with('satker', $satker)
      ->with('data', $data);
  }

  public function detil(Request $request)
  {
    if (!empty($request->id)) {
      $id = $request->id;
    } else {
      $id = 0;
    }

    $data['produk-hukum'] = ProdukHukum::select('produk_hukum.*', 'kategori_produk_hukum.nama_katprod', 'satuan_kerja.nama as satker', 'status_produk.status_produk', 'status_produk.label', 'jenis_produk_hukum.jenis_produk_hukum', 'pejabat_penetap.pejabat_penetap', 'produk_hukum.pejabat_penetap as fid_pejabat_penetap')
      ->Leftjoin('satuan_kerja', 'satuan_kerja.id', '=', 'produk_hukum.fid_satker')
      ->Leftjoin('status_produk', 'status_produk.id', '=', 'produk_hukum.fid_status')
      ->Leftjoin('jenis_produk_hukum', 'jenis_produk_hukum.id', '=', 'produk_hukum.fid_jenis_produk_hukum')
      ->Leftjoin('kategori_produk_hukum', 'produk_hukum.kategori_katprod', '=', 'kategori_produk_hukum.id_katprod')
      ->Leftjoin('pejabat_penetap', 'pejabat_penetap.id', '=', 'produk_hukum.pejabat_penetap')
      ->where('produk_hukum.id', '=', $id)
      ->first();

    if (!empty($data['produk-hukum']->attachment)) {
      $data['produk-hukum']->attachment_fix = $this->attachment_terakhir($id, "file");
    }
    if (!empty($data['produk-hukum']->link_attachment)) {
          if($data['produk-hukum']->link_attachment!="-"){
              $data['produk-hukum']->attachment_fix = $this->attachment_terakhir($id, "link");
          }else{
              $data['produk-hukum']->attachment_fix = $this->attachment_terakhir($id, "file");
          }
    }
    $lampiran = Lampiran::select('lampiran.*', 'users.nama as uploader', 'users.id as id_uploader')
      ->LeftJoin('users', 'users.id', '=', 'lampiran.fid_uploader')
      ->where('fid_produk_hukum', $id)
      ->orderBy('id','DESC')
      ->first();
     
    if (!empty($lampiran->link_attachment)) {
      $data['produk-hukum']->lampiran_link = $lampiran->link_attachment;
    }
    if (!empty($lampiran->attachment)){
      $data['produk-hukum']->lampiran = $lampiran->attachment;  
    }

    $data['kendali-tracking'] = KendaliTracking::select('kendali_tracking.*', 'jenis_tracking.jenis_tracking as status')
      ->Leftjoin('jenis_tracking', 'jenis_tracking.id', '=', 'kendali_tracking.fid_jenis_tracking')
      ->where('kendali_tracking.fid_produk_hukum', '=', $id)
      ->get();

    $master['jenis-tracking'] = JenisTracking::get();

    return view('produk.detil')
      ->with('data', $data)
      ->with('master', $master)
      ->with('id', $id);
  }

  public function proses_tracking(Request $request)
  {
    if ($request->action == 'add') {
      $field = new KendaliTracking;
      $field->fid_produk_hukum = $request->id_usulan;
      $field->fid_jenis_tracking = $request->jenis_tracking;
      $field->tanggal = date('Y-m-d H:i:s');
      $field->save();

      return redirect('produk/detil?id=' . $request->id_usulan)
        ->with('message', 'Tracking Berhasil ditambahkan')
        ->with('message_type', 'success');
    } elseif ($request->action == 'delete') {
      $field = KendaliTracking::find($request->id_tracking);
      $field->delete();
      return redirect('produk/detil?id=' . $request->id_usulan)
        ->with('message', 'Tracking Berhasil dihapus')
        ->with('message_type', 'success');
    }
  }

  public function proses_register(Request $request)
  {
    $field = ProdukHukum::find($request->id);
    if (!empty($field)) {
      $field->nomor = $request->nomor;
      $field->save();
    }
    return redirect('produk/detil?id=' . $request->id)
      ->with('message', 'Nomor Produk Hukum berhasil diregister')
      ->with('message_type', 'success');
  }

  public function get_kendali($id)
  {
    $data = KendaliUsulan::select('kendali_usulan.*', 'jenis_kendali.jenis_kendali', 'jenis_kendali.perintah', 'produk_hukum.judul')
      ->Leftjoin('produk_hukum', 'produk_hukum.id', '=', 'kendali_usulan.fid_produk_hukum')
      ->Leftjoin('jenis_kendali', 'jenis_kendali.id', '=', 'kendali_usulan.fid_jenis_kendali')
      ->where('kendali_usulan.fid_produk_hukum', $id)
      ->get();
    foreach ($data as $key => $value) {
      $master_controller = new MasterController;
      foreach ($data as $key => $value) {
        $data[$key]->asal = $master_controller->userDetil($value->fid_asal);
        $data[$key]->tujuan = $master_controller->userDetil($value->fid_tujuan);
        if (empty($tujuan)) {
          $tujuan = new User;
          $tujuan->nama = '';
        }
        $data[$key]->perintah = str_replace('Asal', $data[$key]->asal->nama, $value->perintah);
        $data[$key]->perintah = str_replace('Judul', '', $data[$key]->perintah);
        $data[$key]->perintah = str_replace('Tujuan', $data[$key]->tujuan->nama, $data[$key]->perintah);
      }
    }
    return $data;
  }

  public function attachment_terakhir($id, $type)
  {
    $attachment = KendaliUsulan::select('kendali_usulan.attachment', 'kendali_usulan.link_attachment')
      ->join('users', 'users.id', '=', 'kendali_usulan.fid_asal')
      ->where('fid_produk_hukum', '=', $id)
      ->where('fid_jenis_kendali', 3)
      ->where('users.hak_akses', 2)
      ->orderBy('tanggal', 'DESC')
      ->first();
    if ($type == "link") {
      if (!empty($attachment)) {
        $data = $attachment->link_attachment;
      } else {
        $produk_hukum = ProdukHukum::where('id', '=', $id)->first();
        $data = $produk_hukum->link_attachment;
      }
    } else {
      if (!empty($attachment)) {
        $data = $attachment->attachment;
      } else {
        $produk_hukum = ProdukHukum::where('id', '=', $id)->first();
        $data = $produk_hukum->attachment;
      }
    }

    return $data;
  }


  public function cetak_register(Request $request)
  {
    if (!empty($request->id)) {
      $id = $request->id;
    } else {
      $id = 0;
    }

    $data['produk-hukum'] = ProdukHukum::select('produk_hukum.*', 'satuan_kerja.nama as satker', 'status_produk.status_produk', 'status_produk.label', 'jenis_produk_hukum.jenis_produk_hukum', 'pejabat_penetap.pejabat_penetap', 'produk_hukum.pejabat_penetap as fid_pejabat_penetap')
      ->Leftjoin('satuan_kerja', 'satuan_kerja.id', '=', 'produk_hukum.fid_satker')
      ->Leftjoin('status_produk', 'status_produk.id', '=', 'produk_hukum.fid_status')
      ->Leftjoin('jenis_produk_hukum', 'jenis_produk_hukum.id', '=', 'produk_hukum.fid_jenis_produk_hukum')
      ->Leftjoin('pejabat_penetap', 'pejabat_penetap.id', '=', 'produk_hukum.pejabat_penetap')
      ->where('produk_hukum.id', '=', $id)
      ->first();

    $data['kendali'] = $this->get_kendali($id);
    return view('produk.cetak_register')
      ->with('data', $data)
      ->with('id', $id);
  }
}