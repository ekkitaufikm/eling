<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\ProdukHukum;
use App\UsulanProdukHukum;
use App\Disposisi;
use App\SifatSurat;
use App\Klasifikasi;
use App\JenisKendali;
use App\KendaliUsulan;
use App\JenisResume;
use App\HakAkses;
use App\JenisProdukHukum;
use App\StatusUsulan;
use App\PejabatPenetap;
use App\User;
use DB;

class ResumeController extends Controller
{

  public function getData($user,$jenis){
    DB::statement("set sql_mode=''");
    DB::statement("set global sql_mode=''");
    //Usulan yang harus dibaca
    if($jenis==1){
      $data=UsulanProdukHukum::select('usulan_produk_hukum.*','satuan_kerja.nama as satker')
        ->Leftjoin('satuan_kerja','satuan_kerja.id','=','usulan_produk_hukum.fid_satker_asal')
        ->where('usulan_produk_hukum.tahun','=',Session::get('yearactive'))
        ->where('usulan_produk_hukum.fid_status','=',1)
        ->orderBy('usulan_produk_hukum.tanggal_surat','DESC')->get();
    }

    //Usulan yang harus didisposisi
    elseif($jenis==2){
      $data=UsulanProdukHukum::select('usulan_produk_hukum.*','satuan_kerja.nama as satker')
        ->Leftjoin('satuan_kerja','satuan_kerja.id','=','usulan_produk_hukum.fid_satker_asal')
        ->where('usulan_produk_hukum.tahun','=',Session::get('yearactive'));

      //Jika Kabag, maka harus mendisposisi surat yang sudah dibaca oleh admin
      if($user=='2'){
        $data=$data->where('usulan_produk_hukum.fid_status','=',2);
      }

      //Jika Kasubbag, maka harus mendisposisi surat yang sudah didisposisi oleh kabag dan belum didisposisi ke staf pelaksana
      else{
        $data=$data->where('usulan_produk_hukum.fid_status','=',3);
      }
      $data=$data->orderBy('usulan_produk_hukum.tanggal_surat','DESC')->get();
    }

    //Produk Hukum yang harus diproses oleh Kabag dan Kasubbag
    elseif($jenis==3){
      //Ambil Data Produk Hukum yang status belum dicetak
      $data=ProdukHukum::select('produk_hukum.*','satuan_kerja.nama as satker','jenis_produk_hukum.jenis_produk_hukum','usulan_produk_hukum.nomor_surat','usulan_produk_hukum.tanggal_surat')
        ->Leftjoin('usulan_produk_hukum','usulan_produk_hukum.id','=','produk_hukum.fid_usulan')
        ->Leftjoin('satuan_kerja','satuan_kerja.id','=','usulan_produk_hukum.fid_satker_asal')
        ->Leftjoin('jenis_produk_hukum','jenis_produk_hukum.id','=','produk_hukum.fid_jenis_produk_hukum')
        ->where('produk_hukum.tahun','=',Session::get('yearactive'))
        ->where('produk_hukum.fid_status','<=',4);

      //Jika Kabag harap merevisi atau menyetujui produk hukum yang sudah di setujui oleh kasubbag
      if($user=='2'){
        $data=$data->join('v_kendali_produk_terakhir','v_kendali_produk_terakhir.fid_produk_hukum','=','produk_hukum.id')
          ->join('users','users.id','=','v_kendali_produk_terakhir.fid_tujuan')
          ->where('v_kendali_produk_terakhir.fid_jenis_kendali','=',3)
          ->where('users.hak_akses','=',2);
      }

      //Jika Kasubbag harap merevisi atau menyetujui produk hukum yang sudah di setujui oleh staff pelaksana
      elseif($user=='3'){
        $data=$data->join('v_kendali_produk_terakhir','v_kendali_produk_terakhir.fid_produk_hukum','=','produk_hukum.id')
          ->join('users','users.id','=','v_kendali_produk_terakhir.fid_tujuan')
          ->where('v_kendali_produk_terakhir.fid_jenis_kendali','=',3)
          ->where('users.hak_akses','=',3);
      }
      $data=$data->orderBy('usulan_produk_hukum.tanggal_surat','DESC')->get();
    }


    //Produk Hukum
    elseif($jenis==4){

      //Ambil Data Produk Hukum yang jenis kendali terakhir disposisi dari kasubbag
      $data=ProdukHukum::select('produk_hukum.*','satuan_kerja.nama as satker','jenis_produk_hukum.jenis_produk_hukum','usulan_produk_hukum.nomor_surat','usulan_produk_hukum.tanggal_surat')
        ->Leftjoin('usulan_produk_hukum','usulan_produk_hukum.id','=','produk_hukum.fid_usulan')
        ->Leftjoin('satuan_kerja','satuan_kerja.id','=','usulan_produk_hukum.fid_satker_asal')
        ->Leftjoin('jenis_produk_hukum','jenis_produk_hukum.id','=','produk_hukum.fid_jenis_produk_hukum')
        ->join('v_disposisi_terakhir','v_disposisi_terakhir.fid_usulan','=','produk_hukum.fid_usulan')
        ->leftJoin('v_kendali_produk_terakhir','v_kendali_produk_terakhir.fid_produk_hukum','=','produk_hukum.id')
        ->where('produk_hukum.tahun','=',Session::get('yearactive')) //Ambil Tahun
        ->where('v_disposisi_terakhir.fid_tujuan','=',Session::get('useractive')->id) //mendapatkan disposisi
        ->where('v_kendali_produk_terakhir.fid_jenis_kendali','=',null) //Belum melakukan revisi/menyetujui
        ->orderBy('usulan_produk_hukum.tanggal_surat','DESC')->get();
    }


    elseif($jenis==5){
      //Ambil Data Produk Hukum yang jenis kendali terakhir revisi dari OPD
      $data=ProdukHukum::select('produk_hukum.*','satuan_kerja.nama as satker','jenis_produk_hukum.jenis_produk_hukum','usulan_produk_hukum.nomor_surat','usulan_produk_hukum.tanggal_surat')
        ->Leftjoin('usulan_produk_hukum','usulan_produk_hukum.id','=','produk_hukum.fid_usulan')
        ->Leftjoin('satuan_kerja','satuan_kerja.id','=','usulan_produk_hukum.fid_satker_asal')
        ->Leftjoin('jenis_produk_hukum','jenis_produk_hukum.id','=','produk_hukum.fid_jenis_produk_hukum')
        ->join('v_kendali_produk_terakhir','v_kendali_produk_terakhir.fid_produk_hukum','=','produk_hukum.id')
        ->join('users','users.id','=','v_kendali_produk_terakhir.fid_asal')
        ->where('produk_hukum.tahun','=',Session::get('yearactive')) //Ambil tahun
        ->where('v_kendali_produk_terakhir.fid_jenis_kendali','=',2) // Jenis Kendali Revisi
        ->where('v_kendali_produk_terakhir.fid_tujuan','=',Session::get('useractive')->id) // Tujuan ke staff pelaksana yang merevisi produk hukum
        ->where('users.hak_akses','=',5) // Asal Revsisi OPD
        ->orderBy('usulan_produk_hukum.tanggal_surat','DESC')->get();
    }
    else{
      //Ambil Data Produk Hukum yang jenis kendali terakhir revisi dari Staff Pelaksana
      $data=ProdukHukum::select('produk_hukum.*','satuan_kerja.nama as satker','jenis_produk_hukum.jenis_produk_hukum','usulan_produk_hukum.nomor_surat','usulan_produk_hukum.tanggal_surat')
        ->Leftjoin('usulan_produk_hukum','usulan_produk_hukum.id','=','produk_hukum.fid_usulan')
        ->Leftjoin('satuan_kerja','satuan_kerja.id','=','usulan_produk_hukum.fid_satker_asal')
        ->Leftjoin('jenis_produk_hukum','jenis_produk_hukum.id','=','produk_hukum.fid_jenis_produk_hukum')
        ->join('v_kendali_produk_terakhir','v_kendali_produk_terakhir.fid_produk_hukum','=','produk_hukum.id')
        ->join('users','users.id','=','v_kendali_produk_terakhir.fid_asal')
        ->where('produk_hukum.tahun','=',Session::get('yearactive')) //Ambil tahun
        ->where('v_kendali_produk_terakhir.fid_jenis_kendali','=',2) // Jenis Kendali Revisi
        ->where('v_kendali_produk_terakhir.fid_tujuan','=',Session::get('useractive')->id) // Tujuan ke OPD yang merevisi produk hukum
        ->where('users.hak_akses','=',5) // Asal Revsisi OPD
        ->orderBy('usulan_produk_hukum.tanggal_surat','DESC')->get();
    }
    return $data;
  }


  public function getJenisResume($jenis,$hak_akses){
    $jenis_kendali=JenisResume::select('*');
    if($hak_akses==1){
      $jenis_kendali=$jenis_kendali->where('id','=',1); //Administrator hanya bisa terima surat
      $default=1;
    }
    elseif($hak_akses==2 || $hak_akses==3){
      $jenis_kendali=$jenis_kendali->whereRaw('id IN (2,3)'); //Kabag dan Kasubbag hanya bisa disposisi  surat dan proses produk hukum
      $default=2;
    }
    elseif($hak_akses==4){
      $jenis_kendali=$jenis_kendali->whereRaw('id IN (4,5)'); //Staff Pelaksana Hanya bisa memproses (Setuju / Revisi) yang berasal dari Dispoisi Kasubbag dan Revsi dari OPD
      $default=4;
    }
    else{
      $jenis_kendali=$jenis_kendali->where('id','=','6'); //OPD Hanya bisa merevisi produk hukum yang direvisi oleh Staf Pelaksana
      $default=6;
    }
    $jenis_kendali=$jenis_kendali->get();

    if($jenis=='master'){
      return $jenis_kendali;
    }
    else{
      return $default;
    }
  }

  public function setData(Request $request){
    return redirect('resume/default/'.$request->jenis);
  }

  public function index($user='default',$jenis='default'){
    if($user=='default'){
      $user=Session::get('useractive')->hak_akses;
    }
    if($jenis=='default'){
      $jenis=$this->getJenisResume('default',Session::get('useractive')->hak_akses);
    }
    $data=$this->getData($user,$jenis);
    $master['jenis-resume']=$this->getJenisResume('master',Session::get('useractive')->hak_akses);
    $master['hak-akses']=HakAkses::get();
    $master['perintah-resume']=JenisResume::find($jenis);
    return view('resume')
      ->with('jenis',$jenis)
      ->with('user',$user)
      ->with('master',$master)
      ->with('data',$data);
  }
}
