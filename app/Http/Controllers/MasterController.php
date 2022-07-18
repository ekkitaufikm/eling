<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\User;
use App\HakAkses;
use App\Satker;
use App\JenisProdukHukum;
use App\Kinerja;
use App\StatusUsulan;
use App\StatusProduk;
use App\SinglePost;
use App\Slider;
use App\Informasi;
use DB;
use Redirect;

class MasterController extends Controller
{

  //----------------------------------------------------------------------------------------------------------------------//
  //------------------------------------------------------MASTER USER-----------------------------------------------------//
  //----------------------------------------------------------------------------------------------------------------------//

  //Ambil Data User per Page
  public function getUser($search)
  {
    $query = User::select('users.*', 'satuan_kerja.nama as satker', 'hak_akses.hak_akses')
      ->Leftjoin('hak_akses', 'hak_akses.id', '=', 'users.hak_akses')
      ->Leftjoin('satuan_kerja', 'satuan_kerja.id', '=', 'users.fid_satker');

    if (!empty($search)) {
      $query = $query->whereRaw("(users.nama LIKE '%" . $search . "%'
                                  or satuan_kerja.nama LIKE '%" . $search . "%'
                                  or users.username LIKE '%" . $search . "%'
                                  or hak_akses.hak_akses LIKE '%" . $search . "%' )");
    }

    $result = $query->paginate(10);
    if (!empty($search)) {
      $result->withPath('user?search=' . $search);
    }
    return $result;
  }


  //Return view User
  public function userTampil()
  {

    $data['user'] = User::select('users.*', 'satuan_kerja.nama as satker', 'hak_akses.hak_akses')
      ->Leftjoin('hak_akses', 'hak_akses.id', '=', 'users.hak_akses')
      ->Leftjoin('satuan_kerja', 'satuan_kerja.id', '=', 'users.fid_satker')
      ->get();
    $master['satker'] = Satker::get();
    $master['hak_akses'] = HakAkses::get();
    return view('master.user')
      ->with('master', $master)
      ->with('data', $data);
  }

  public function prosesUser(Request $request, $action = 'simpan')
  {
    if ($action == 'simpan') {
      if ($request->id == 0) {
        $kolom = new User;
      } else {
        $kolom = User::find($request->id);
      }
      $kolom->fid_satker = $request->satker;
      $kolom->username = $request->username;
      $kolom->nama = $request->nama_lengkap;
      if (!empty($request->password)) {
        $kolom->userpass = encrypt($request->password);
      }
      $kolom->hak_akses = $request->hak_akses;
      $kolom->email = $request->email;
      $kolom->phone = $request->hp;
      $kolom->save();
      return redirect('master/user')
        ->with('message', 'Master User berhasil disimpan')
        ->with('message_type', 'success');
    } else {
      $pisah = explode('=', $action);
      $kolom = User::find($pisah[1]);
      $kolom->delete();
      return redirect('master/user')
        ->with('message', 'Master User berhasil dihapus')
        ->with('message_type', 'success');
    }
  }

  public function userDetil($id)
  {
    $data = User::where('id', '=', $id)->first();
    return $data;
  }

  //----------------------------------------------------------------------------------------------------------------------//
  //------------------------------------------------------MASTER SATKER---------------------------------------------------//
  //----------------------------------------------------------------------------------------------------------------------//


  //Ambil Data Satker per Page
  public function getSatker($search)
  {

    $query = Satker::select('satuan_kerja.*', 'parent.nama as nama_parent')
      ->leftJoin('satuan_kerja as parent', 'parent.id', '=', 'satuan_kerja.parent_id')
      ->orderBy('kode_satker');


    if (!empty($search)) {
      $query = $query->whereRaw("(satuan_kerja.nama LIKE '%" . $search . "%' or satuan_kerja.kode_satker LIKE '%" . $search . "%')");
    }

    $result = $query->paginate(10);
    if (!empty($search)) {
      $result->withPath('satker?search=' . $search);
    }
    return $result;
  }

  //return view satker
  public function satkerTampil()
  {

    $data['satker'] = Satker::select('satuan_kerja.*', 'parent.nama as nama_parent')
      ->leftJoin('satuan_kerja as parent', 'parent.id', '=', 'satuan_kerja.parent_id')
      ->orderBy('kode_satker')
      ->get();

    $data['satker2'] = Satker::all();

    $master['satker'] = Satker::get();
    return view('master.satker')
      ->with('master', $master)
      ->with('data', $data);
  }

  public function prosesSatker(Request $request, $action = 'simpan')
  {
    if ($action == 'simpan') {
      if ($request->id == 0) {
        $kolom = new Satker;
      } else {
        $kolom = Satker::find($request->id);
      }
      $kolom->nama = $request->nama;
      $kolom->kode_satker = $request->kode;
      $kolom->parent_id = $request->parent;
      $kolom->tahun = Session::get('yearactive');
      $kolom->save();
      return redirect('master/satker')
        ->with('message', 'Master Satker berhasil disimpan')
        ->with('message_type', 'success');
    } else {
      $pisah = explode('=', $action);
      $kolom = Satker::find($pisah[1]);
      $kolom->delete();
      return redirect('master/satker')
        ->with('message', 'Master Satker berhasil dihapus')
        ->with('message_type', 'success');
    }
  }

  public function update_statusSatker($id, $status)
  {
    $data = Satker::find($id);
    $data->publish = $status;
    $data->save();
    return response()->json(['status' => true]);
  }

  //----------------------------------------------------------------------------------------------------------------------//
  //------------------------------------------------------MASTER SATKER---------------------------------------------------//
  //----------------------------------------------------------------------------------------------------------------------//

  public function getKinerja($search, $page)
  {
    DB::statement("set sql_mode=''");
    DB::statement("set global sql_mode=''");
    $perpage = 10;
    $query = Kinerja::select('data_kinerja.*', 'jenis_produk_hukum.jenis_produk_hukum')
      ->join('jenis_produk_hukum', 'jenis_produk_hukum.id', '=', 'data_kinerja.fid_jenis_produk_hukum')
      ->orderBy('bulan');

    $data['datatotal'] = $query->count();
    $data['pagetotal'] = ceil($query->count() / $perpage);
    $data['perpage'] = $perpage;
    $data['pageposition'] = $page;
    $result = $query->skip(($page - 1) * $perpage)->take($perpage)->get();
    $data['data'] = $result;
    return $data;
  }

  public function kinerjaTampil($search = 'all', $page = '1')
  {
    $data = $this->getKinerja($search, $page);
    $master['jenis-produk-hukum'] = JenisProdukHukum::get();
    return view('master.kinerja')
      ->with('master', $master)
      ->with('search', $search)
      ->with('data', $data);
  }

  public function prosesKinerja(Request $request, $action = 'simpan')
  {
    if ($action == 'simpan') {
      if ($request->id == 0) {
        $kolom = new Kinerja;
      } else {
        $kolom = Kinerja::find($request->id);
      }
      $kolom->fid_jenis_produk_hukum = $request->jenis;
      $kolom->bulan = $request->bulan;
      $kolom->jumlah = $request->jumlah;
      $kolom->save();
      return redirect('master/kinerja')
        ->with('message', 'Data Kinerja Bagian Hukum berhasil disimpan')
        ->with('message_type', 'success');
    } else {
      $pisah = explode('=', $action);
      $kolom = Kinerja::find($pisah[1]);
      $kolom->delete();
      return redirect('master/kinerja')
        ->with('message', 'Data Kinerja Bagian Hukum berhasil dihapus')
        ->with('message_type', 'success');
    }
  }

  public function jumKinerja($jenis, $bulan)
  {
    return Kinerja::where('fid_jenis_produk_hukum', '=', $jenis)->where('bulan', '=', $bulan)->sum('jumlah');
  }

  public function ubahPassword(Request $request, $id)
  {
    $cek_user = User::find($id);
    if (!empty($cek_user)) {
      if (decrypt($cek_user->userpass) == $request->pass_lama) {
        if ($request->pass_baru == $request->re_pass_baru) {
          $cek_user->userpass = encrypt($request->re_pass_baru);
          $cek_user->save();
          return Redirect::back()
            ->with('message', 'Password Berhasil Diubah')
            ->with('message_type', 'success');
        } else {
          return Redirect::back()
            ->with('message', 'Password Baru Tidak Sama')
            ->with('message_type', 'warning');
        }
      } else {
        return Redirect::back()
          ->with('message', 'Password Lama Tidak Sama')
          ->with('message_type', 'warning');
      }
    }
  }
  public function ubahTahun(Request $request)
  {
    Session::put('yearactive', $request->tahun);
    return Redirect::back()
      ->with('message', 'Tahun Registrasi Berhasil Diubah')
      ->with('message_type', 'success');
  }

  //----------------------------------------------------------------------------------------------------------------------//
  //------------------------------------------------------MASTER SETTING STATUS---------------------------------------------------//
  //----------------------------------------------------------------------------------------------------------------------//

  public function statusTampil()
  {
    $data['produk'] = DB::table('status_produk')->get();
    return view('master.status')
      ->with('data', $data);
  }

  public function proses_status(Request $request, $jenis)
  {
    foreach ($request->id as $value) {
      $field = StatusProduk::find($value);
      $field->status_produk = $request->status[$value];
      $field->label = $request->label[$value];
      $field->save();
    }
    return Redirect::back()
      ->with('message', 'Status Usulan Produk Hukum Berhasil Diubah')
      ->with('message_type', 'success');
  }

  //----------------------------------------------------------------------------------------------------------------------//
  //--------------------------------------------------SETTING DASHBOARD---------------------------------------------------//
  //----------------------------------------------------------------------------------------------------------------------//

  public function settingDashboard()
  {
    $single_post = SinglePost::get();
    foreach ($single_post as $key => $value) {
      $data['single-post'][$value->id] = SinglePost::find($value->id);
    }
    $data['slider'] = Slider::where('publish','1')->orderby('order')->get();
    return view('master.dashboard')
      ->with('data', $data);
  }

  public function saveDashboard(Request $request)
  {
    $field = SinglePost::find($request->id);
    if ($request->id == 3 || $request->id == 4) {
      if ($request->hasFile('content')) {
        if (!empty($field->content)) {
          unlink(storage_path('app/' . $field->content));
        }
        $uploadedFile = $request->file('content');
        $path = $uploadedFile->store('landing_page');
        $field->content = $path;
      }
    } else {
      $field->content = $request->content;
    }
    $field->save();

    return Redirect::back()
      ->with('message', $field->judul . ' sudah disimpan')
      ->with('message_type', 'success');
  }

  //----------------------------------------------------------------------------------------------------------------------//
  //--------------------------------------------------SLIDESHOW---------------------------------------------------//
  //----------------------------------------------------------------------------------------------------------------------//

  public function slideshowTampil()
  {
    $data['slider'] = DB::table('slider')->get();
    return view('master.slider')
      ->with('data', $data);
  }

  public function proses_slideshow(Request $request, $action = null)
  {
    if ($action == 'simpan') {
      if ($request->id == 0) {
        $kolom = new Slider;
      } else {
        $kolom = Slider::find($request->id);
      }
      $kolom->judul = $request->judul;
      $kolom->order = $request->order;
      if ($request->hasFile('slider')) {
        $uploadedFile = $request->file('slider');
        $path = $uploadedFile->store('slide_show');
        $kolom->slider = $path;
      }
      
      $kolom->save();
      return redirect('master/slider')
        ->with('message', 'Master Slide Show berhasil disimpan')
        ->with('message_type', 'success');
    } else {
      $pisah = explode('=', $action);
      $kolom = Slider::find($pisah[1]);
      $kolom->delete();
      return redirect('master/slider')
        ->with('message', 'Master Slide Show berhasil dihapus')
        ->with('message_type', 'success');
    }
  }

  public function update_statusslideshow($id)
  {
    $data = Slider::find($id);
    if ($data->publish=="1") {
      $data->publish = "0";
      $data->save();
    } else {
      $data->publish = "1";
      $data->save();
    }
    return response()->json(['status' => true]);
  }

  //----------------------------------------------------------------------------------------------------------------------//
  //--------------------------------------------------INFORMASI---------------------------------------------------//
  //----------------------------------------------------------------------------------------------------------------------//

  public function infoTampil()
  {
    $data['info'] = DB::table('tb_informasi')->orderby('created_at','DESC')->get();
    return view('master.informasi')
      ->with('data', $data);
  }

  public function proses_info(Request $request, $action = null)
  {
    if ($action == 'simpan') {
      if ($request->id_informasi == 0) {
        $kolom = new Informasi;
      } else {
        $kolom = Informasi::find($request->id_informasi);
      }
      $kolom->judul_informasi = $request->judul_informasi;
      if ($request->hasFile('file_informasi')) {
        $uploadedFile = $request->file('file_informasi');
        $path = $uploadedFile->store('informasi');
        $kolom->file_informasi = $path;
      }
      
      $kolom->save();
      return redirect('master/info')
        ->with('message', 'Master Informasi berhasil disimpan')
        ->with('message_type', 'success');
    } else {
      $pisah = explode('=', $action);
      $kolom = Informasi::find($pisah[1]);
      $kolom->delete();
      return redirect('master/info')
        ->with('message', 'Master Informasi berhasil dihapus')
        ->with('message_type', 'success');
    }
  }

  public function update_statusinfo($id)
  {
    $data = Informasi::find($id);
    if ($data->publish=="1") {
      $data->publish = "0";
      $data->save();
    } else {
      $data->publish = "1";
      $data->save();
    }
    return response()->json(['status' => true]);
  }
}