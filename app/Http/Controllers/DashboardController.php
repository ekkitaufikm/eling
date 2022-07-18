<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\JenisProdukHukum;
use App\Kinerja;
use App\SinglePost;
use App\Slider;
use App\Informasi;
use App\ProdukHukum;
use App\UsulanProdukHukum;
use App\StatusProduk;
use App\KendaliUsulan;
use DB;

class DashboardController extends Controller
{

  public function landingPage(){
    $single_post=SinglePost::get();
    foreach ($single_post as $key => $value) {
      $data['single-post'][$value->id]=SinglePost::find($value->id);
    }
    $data['slider']=Slider::where('publish','1')->orderby('order')->get();

    return view('landing-page')
      ->with('data',$data);
  }

  public function get_data($bulan,$jenis){
    $query=ProdukHukum::where('fid_jenis_produk_hukum','=',$jenis);
    if($bulan!='all'){
      $query=$query->whereMonth('tanggal_usulan','=',$bulan);
    }
    $data=$query->whereYear('tanggal_usulan','=',Session::get('yearactive'))->count();
    return $data;
  }

  public function index(){
    $jenis_produk_hukum=JenisProdukHukum::get();
    $bulan = array ('01', '02', '03', '04' , '05' , '06' , '07' , '08' , '09' , '10' , '11' , '12');
    foreach ($jenis_produk_hukum as $key => $value) {
      foreach ($bulan as $bln){
        $nilai[$bln]=$this->get_data($bln,$value->id);
      }
      $jenis_produk_hukum[$key]->nilai=$nilai;
      $jenis_produk_hukum[$key]->nilai_tahunan=$this->get_data('all',$value->id);
      $jenis_produk_hukum[$key]->nilai_total=ProdukHukum::where('fid_jenis_produk_hukum','=',$value->id)->whereYear('tanggal_usulan','=',Session::get('yearactive'))->count();
    }
    $data['jenis-produk-hukum']=$jenis_produk_hukum;
    //total semua usulan produk
    $data['total-usulan-produk-semua'] = ProdukHukum::where('tahun',Session::get('yearactive'))->get();
    $set_data = ProdukHukum::whereraw("fid_status != '9'")->where('tahun',Session::get('yearactive'))->get();
    //total usulan produk kabag
    $data['total-usulan-produk-kabag'] = 0;
    //total usulan produk kasubag
    $data['total-usulan-produk-kasubag'] = 0;
    //total usulan produk staff
    $data['total-usulan-produk-staff'] = 0;
    //total pekerjaan didelivery ke user
    $data['total-job-deliv'] = 0;
    foreach ($data['total-usulan-produk-semua'] as $item) {
      $get_data_kendali = KendaliUsulan::leftjoin('users','kendali_usulan.fid_asal','users.id')
      ->where('fid_produk_hukum',$item->id)
      ->orderBy('tanggal','DESC')
      ->limit(1)
      ->first();
      if (empty($get_data_kendali->hak_akses)) {
        continue;
      }
      if ($get_data_kendali->hak_akses=="2") {
        $data['total-usulan-produk-kabag'] += 1;
      }
      
      if ($get_data_kendali->hak_akses=="3") {
        $data['total-usulan-produk-kasubag'] += 1;
      }

      if ($get_data_kendali->hak_akses=="4") {
        $data['total-usulan-produk-staff'] += 1;
      }

      if (Session::get('useractive')->id==$get_data_kendali->fid_tujuan) {
        $data['total-job-deliv'] += 1;
      }
    }
    //total produk hukum proses
    $data['total-produk-proses'] = $set_data;
    //total produk hukum selesai
    $data['total-produk-selesai'] = ProdukHukum::whereraw("fid_status = '9'")->where('tahun',Session::get('yearactive'))->get();
    //total porduk hukum tolak / gagal
    $data['total-produk-gagal'] = ProdukHukum::whereraw("fid_status = '0'")->where('tahun',Session::get('yearactive'))->get();
    //get informasi
    $data['info'] = Informasi::where('publish','1')->orderby('created_at','DESC')->get();
    //get slider
    $data['slider'] = Slider::where('publish','1')->orderby('order')->get();
    return view('dashboard')
      ->with('data',$data);
  }

  public function display(){
    $data = ProdukHukum::select('produk_hukum.*','satuan_kerja.nama as satker','status_produk.status_produk','status_produk.label','jenis_produk_hukum.jenis_produk_hukum','pejabat_penetap.pejabat_penetap')
      ->Leftjoin('satuan_kerja','satuan_kerja.id','=','produk_hukum.fid_satker')
      ->Leftjoin('status_produk','status_produk.id','=','produk_hukum.fid_status')
      ->Leftjoin('jenis_produk_hukum','jenis_produk_hukum.id','=','produk_hukum.fid_jenis_produk_hukum')
      ->Leftjoin('pejabat_penetap','pejabat_penetap.id','=','produk_hukum.pejabat_penetap')
      ->where('produk_hukum.tahun','=',Session::get('yearactive'))
      ->orderBy('usulan_produk_hukum.tanggal_surat','DESC')->get();
    return view('display')->with('data',$data);
  }
}
