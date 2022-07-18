<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\ProdukHukum;
use App\JenisKendali;
use App\KendaliUsulan;
use App\JenisProdukHukum;
use App\StatusProduk;
use App\PejabatPenetap;
use App\User;
use App\Notifikasi;
use App\Lampiran;
use App\KategoriProdukHukum;
use App\Log;
use Illuminate\Support\Facades\Auth;
use DB;

class UsulanController extends Controller
{
  public function dateFormat($date, $format)
  {
    $date = date_create($date);
    $date_new = date_format($date, $format);
    return $date_new;
  }

  public function otoritas_kendali($id)
  {
    if (Session::get('useractive')->hak_akses == 1) {
      $otoritas = '';
    } else {
      $cek_kendali = KendaliUsulan::where('fid_produk_hukum', $id)->where('fid_tujuan', Session::get('useractive')->id)->first();
      if (!empty($cek_kendali)) {
        $otoritas = '';
      } else {
        $otoritas = 'disabled';
      }
    }
    return $otoritas;
  }

  public function status_usulan($id)
  {
    $produk_hukum = ProdukHukum::find($id);
    if (!empty($produk_hukum)) {
      $kendali = KendaliUsulan::where('fid_produk_hukum', $id)->orderBy('tanggal', 'DESC')->first();
      if (!empty($kendali)) {
        //Jika jenis kendali Diteruskan
        if ($kendali->fid_jenis_kendali == 6) {
          $status = 0; //Status dikembalikan ke OPD
        }
        //Jika jenis kendali Diteruskan
        if ($kendali->fid_jenis_kendali == 5) {
          $status = 2; //Status sudah diteruskan
        }
        //Jika jenis kendali disposisi
        elseif ($kendali->fid_jenis_kendali == 1) {
          $user = User::find($kendali->fid_asal);
          if (!empty($user)) {
            //Jika disposisi dari kabag
            if ($user->hak_akses == 2) {
              $status = 3; //Disposisi Kabag
            }
            //Jika disposisi dari kasubbag
            elseif ($user->hak_akses == 3) {
              $status = 4; //Disposisi Kasbubbag
            }
          } else {
            $status = 3; //Disposisi Kabag
          }
        }
        //Jika jenis kendali revisi
        elseif ($kendali->fid_jenis_kendali == 2) {
          $status = 5; //Revisi
        }
        //Jika jenis kendali disetujui
        elseif ($kendali->fid_jenis_kendali == 3) {
          $user = User::find($kendali->fid_asal);
          if (!empty($user)) {
            //jika Disetujui kabag
            if ($user->hak_akses == 2) {
              $status = 9; //Disetujui Kabag
            }
            //jika Disetujui kasubbag
            elseif ($user->hak_akses == 3) {
              $status = 8; //Disetujui Kasubbag
            }
            //jika Disetujui staff
            elseif ($user->hak_akses == 4) {
              $status = 7; //Disetujui staff
            } else {
              $status = 7; //Disetujui staff
            }
          } else {
            $status = 7; //Disetujui staff
          }
        } elseif ($kendali->fid_jenis_kendali == 4) {
          $status = 6; //Disetujui staff
        }
      } else {
        $status = 1;
      }
    }
    return $status;
  }

  public function index(Request $request)
  {

    if (!empty($request->satker)) {
      $satker = $request->satker;
    } else {
      $satker = 'all';
    }

    if (!empty($request->status)) {
      $status = $request->status;
    } else {
      $status = 'all';
    }

    //$data['usulan']=$this->get_produk_hukum($search,$satker,$status);
    //datatables query 
    $query = ProdukHukum::select('produk_hukum.*', 'satuan_kerja.nama as satker', 'status_produk.status_produk', 'status_produk.label', 'jenis_produk_hukum.jenis_produk_hukum', 'pejabat_penetap.pejabat_penetap')
      ->Leftjoin('satuan_kerja', 'satuan_kerja.id', '=', 'produk_hukum.fid_satker')
      ->Leftjoin('status_produk', 'status_produk.id', '=', 'produk_hukum.fid_status')
      ->Leftjoin('jenis_produk_hukum', 'jenis_produk_hukum.id', '=', 'produk_hukum.fid_jenis_produk_hukum')
      ->Leftjoin('pejabat_penetap', 'pejabat_penetap.id', '=', 'produk_hukum.pejabat_penetap')
      ->where('produk_hukum.tahun', '=', Session::get('yearactive'))
      ->orderBy('produk_hukum.tanggal_usulan', 'DESC');

    if (Session::get('useractive')->hak_akses == 5) {
      $query = $query->where('produk_hukum.fid_satker', '=', Session::get('useractive')->fid_satker)->get();
    } elseif (Session::get('useractive')->hak_akses == 4) {
      $query = $query->Rightjoin('kendali_usulan', 'kendali_usulan.fid_produk_hukum', '=', 'produk_hukum.id')
        ->where('kendali_usulan.fid_tujuan', '=', Session::get('useractive')->id)
        ->groupBy('produk_hukum.id')
        ->get();
    } else {
      $query = $query->get();
    }

    // jika status revisi
    $master = new MasterController;
    foreach ($query as $key => $value) {
      $dari = KendaliUsulan::select('kendali_usulan.fid_asal as dari', 'kendali_usulan.fid_tujuan as ke')
        ->where('kendali_usulan.fid_produk_hukum', '=', $query[$key]->id)
        ->orderBy('kendali_usulan.tanggal', 'DESC')
        ->first();
      if (Session::get('useractive')->hak_akses != "5") {

        if (empty($dari)) {
          $query[$key]->ishak_ke = "0";
          $query[$key]->isdone = "0";
        } else {
          $query[$key]->ishak_ke = $master->userDetil($dari->ke)->hak_akses;

          $query[$key]->isdone = (Session::get('useractive')->id == $dari->ke) ? "0" : "1";
        }
      }


      if ($query[$key]->status_produk == 'REVISI') {

        $master = new MasterController;

        if ($master->userDetil($dari->dari)->hak_akses == 2) {
          $query[$key]->status_produk = $query[$key]->status_produk . ' KABAG';
          $query[$key]->label = "#00cc0e";
        } elseif ($master->userDetil($dari->dari)->hak_akses == 3) {
          $query[$key]->status_produk = $query[$key]->status_produk . ' KASUBAG';
          $query[$key]->label = "#00cc69";
        } elseif ($master->userDetil($dari->dari)->hak_akses == 4) {
          $query[$key]->status_produk = $query[$key]->status_produk . ' STAF';
        }
      }
    }


    $data['usulan2'] = $query;
    //end datatables query


    $data['status-usulan'] = StatusProduk::get();
    return view('usulan.index')
      ->with('status', $status)
      ->with('satker', $satker)
      ->with('data', $data);
  }
  
   public function list_hapus(Request $request)
  {

    if (!empty($request->satker)) {
      $satker = $request->satker;
    } else {
      $satker = 'all';
    }

    if (!empty($request->status)) {
      $status = $request->status;
    } else {
      $status = 'all';
    }

    //$data['usulan']=$this->get_produk_hukum($search,$satker,$status);
    //datatables query 
    $query = DB::table('produk_hukum')->select('produk_hukum.*', 'satuan_kerja.nama as satker', 'status_produk.status_produk', 'status_produk.label', 'jenis_produk_hukum.jenis_produk_hukum', 'pejabat_penetap.pejabat_penetap')
      ->Leftjoin('satuan_kerja', 'satuan_kerja.id', '=', 'produk_hukum.fid_satker')
      ->Leftjoin('status_produk', 'status_produk.id', '=', 'produk_hukum.fid_status')
      ->Leftjoin('jenis_produk_hukum', 'jenis_produk_hukum.id', '=', 'produk_hukum.fid_jenis_produk_hukum')
      ->Leftjoin('pejabat_penetap', 'pejabat_penetap.id', '=', 'produk_hukum.pejabat_penetap')
      ->where('produk_hukum.tahun', '=', Session::get('yearactive'))
      ->whereRaw('produk_hukum.deleted_at IS NOT NULL')
      ->orderBy('produk_hukum.tanggal_usulan', 'DESC');

    if (Session::get('useractive')->hak_akses == 5) {
      $query = $query->where('produk_hukum.fid_satker', '=', Session::get('useractive')->fid_satker)->get();
    } elseif (Session::get('useractive')->hak_akses == 4) {
      $query = $query->Rightjoin('kendali_usulan', 'kendali_usulan.fid_produk_hukum', '=', 'produk_hukum.id')
        ->where('kendali_usulan.fid_tujuan', '=', Session::get('useractive')->id)
        ->groupBy('produk_hukum.id')
        ->get();
    } else {
      $query = $query->get();
    }

    // jika status revisi
    $master = new MasterController;
    foreach ($query as $key => $value) {
      $dari = KendaliUsulan::select('kendali_usulan.fid_asal as dari', 'kendali_usulan.fid_tujuan as ke')
        ->where('kendali_usulan.fid_produk_hukum', '=', $query[$key]->id)
        ->orderBy('kendali_usulan.tanggal', 'DESC')
        ->first();
      if (Session::get('useractive')->hak_akses != "5") {

        if (empty($dari)) {
          $query[$key]->ishak_ke = "0";
          $query[$key]->isdone = "0";
        } else {
          $query[$key]->ishak_ke = $master->userDetil($dari->ke)->hak_akses;

          $query[$key]->isdone = (Session::get('useractive')->id == $dari->ke) ? "0" : "1";
        }
      }


      if ($query[$key]->status_produk == 'REVISI') {

        $master = new MasterController;

        if ($master->userDetil($dari->dari)->hak_akses == 2) {
          $query[$key]->status_produk = $query[$key]->status_produk . ' KABAG';
          $query[$key]->label = "#00cc0e";
        } elseif ($master->userDetil($dari->dari)->hak_akses == 3) {
          $query[$key]->status_produk = $query[$key]->status_produk . ' KASUBAG';
          $query[$key]->label = "#00cc69";
        } elseif ($master->userDetil($dari->dari)->hak_akses == 4) {
          $query[$key]->status_produk = $query[$key]->status_produk . ' STAF';
        }
      }
    }


    $data['usulan2'] = $query;
    //end datatables query


    $data['status-usulan'] = StatusProduk::get();
    return view('usulan.list_hapus')
      ->with('status', $status)
      ->with('satker', $satker)
      ->with('data', $data);
  }

  public function get_kendali($id, $type = null)
  {
    if (!empty($type)) {
      $condition = array(
        'kendali_usulan.fid_produk_hukum' => $id,
        'kendali_usulan.status_usulan' => $type
      );
    } else {
      $condition = array(
        'kendali_usulan.fid_produk_hukum' => $id
      );
    }
    $data = KendaliUsulan::select('kendali_usulan.*', 'jenis_kendali.jenis_kendali', 'jenis_kendali.perintah', 'produk_hukum.judul')
      ->Leftjoin('produk_hukum', 'produk_hukum.id', '=', 'kendali_usulan.fid_produk_hukum')
      ->Leftjoin('jenis_kendali', 'jenis_kendali.id', '=', 'kendali_usulan.fid_jenis_kendali')
      ->where($condition)
      ->orderBy('kendali_usulan.tanggal')
      ->groupBy('id')
      ->get();

    $master_controller = new MasterController;
    foreach ($data as $key => $value) {
      $data[$key]->asal = $master_controller->userDetil($value->fid_asal);
      $data[$key]->tujuan = $master_controller->userDetil($value->fid_tujuan);
      if (empty($tujuan)) {
        $tujuan = new User;
        $tujuan->nama = '';
      }
      $data[$key]->perintah = str_replace('Asal', $data[$key]->asal->nama, $value->perintah);
      $data[$key]->perintah = str_replace('Judul', $data[$key]->judul, $data[$key]->perintah);
      $data[$key]->perintah = str_replace('Tujuan', $data[$key]->tujuan->nama, $data[$key]->perintah);
    }

    return $data;
  }

  public function form(Request $request)
  {
    if (!empty($request->id)) {
      $id = $request->id;
    } else {
      $id = 0;
    }

    if (!empty($request->tab)) {
      $tab = $request->tab;
    } else {
      $tab = 'produk';
    }

    if (!empty($request->kendali)) {
      $id_kendali = $request->kendali;
    } elseif (!empty($request->detailkendali)) {
      $id_kendali = $request->detailkendali;
    } else {
      $id_kendali = 0;
    }

    if (!empty($request->lampiran)) {
      $id_lampiran = $request->lampiran;
    } elseif (!empty($request->detaillampiran)) {
      $id_lampiran = $request->detaillampiran;
    } else {
      $id_lampiran = 0;
    }

    $data['produk'] = ProdukHukum::select('produk_hukum.*', 'satuan_kerja.nama as satker', 'status_produk.status_produk', 'status_produk.label', 'jenis_produk_hukum.jenis_produk_hukum', 'pejabat_penetap.pejabat_penetap')
      ->Leftjoin('satuan_kerja', 'satuan_kerja.id', '=', 'produk_hukum.fid_satker')
      ->Leftjoin('status_produk', 'status_produk.id', '=', 'produk_hukum.fid_status')
      ->Leftjoin('jenis_produk_hukum', 'jenis_produk_hukum.id', '=', 'produk_hukum.fid_jenis_produk_hukum')
      ->Leftjoin('pejabat_penetap', 'pejabat_penetap.id', '=', 'produk_hukum.pejabat_penetap')
      ->where('produk_hukum.id', '=', $id)
      ->first();

    if (!empty($data['produk'])) {
      $master['tujuan-disposisi'] = User::where('hak_akses', '!=', 1)
        ->where('hak_akses', '<', 5)
        ->where('hak_akses', '>', Session::get('useractive')->hak_akses)
        ->orderBy('hak_akses')
        ->get();

      $master['tujuan-revisi'] = User::where('hak_akses', '>', 1)
        ->where('hak_akses', '<', 5)
        ->where('id', '!=', Session::get('useractive')->id)
        ->orWhere('id', '=', $data['produk']->fid_user)
        ->orderBy('hak_akses')
        ->get();
    }

    $data['kendali-detil'] = KendaliUsulan::find($id_kendali);
    $data['kendali'] = $this->get_kendali($id);
    // if ($tab=="form_kendali") {
    $data['kendali-belum'] = $this->get_kendali($id, "1");
    $data['kendali-selesai'] = $this->get_kendali($id, "2");
    // }

    $data['lampiran'] = Lampiran::select('lampiran.*', 'users.nama as uploader', 'users.id as id_uploader')
      ->LeftJoin('users', 'users.id', '=', 'lampiran.fid_uploader')
      ->where('fid_produk_hukum', $id)
      ->get();
    $data['lampiran-detil'] = Lampiran::find($id_lampiran);

    $master['jenis-produk-hukum'] = JenisProdukHukum::get();
    $master['pejabat-penetap'] = PejabatPenetap::get();
    $master['kategori-produk-hukum'] = KategoriProdukHukum::orderBy('nama_katprod')->get();
    $master['jenis-kendali'] = $this->jenis_kendali_usulan();

    $data['otoritas'] = $this->otoritas_kendali($id);

    $data['data_log'] = Log::leftjoin('lampiran','id','=','lampiran_log')->where('produk_log',$id)->orderby('created_at','DESC')->get();

    if ($tab == "kendali" || $tab == "lampiran" || $tab == "detail") {
      $set_tab = "detail";
    } elseif ($tab=="detail_log") {
      $set_tab = "detail_log";
    }else{
      $set_tab = $tab;
    }

    return view('usulan.form.index')
      ->with('data', $data)
      ->with('master', $master)
      ->with('id_kendali', $id_kendali)
      ->with('id_lampiran', $id_lampiran)
      ->with('tab', $set_tab)
      // ->with('tab','detail')
      ->with('id', $id);
  }

  public function detail(Request $request)
  {
    if (!empty($request->id)) {
      $id = $request->id;
    } else {
      $id = 0;
    }

    if (!empty($request->kendali)) {
      $id_kendali = $request->kendali;
    } else {
      $id_kendali = 0;
    }

    if (!empty($request->lampiran)) {
      $id_lampiran = $request->lampiran;
    } else {
      $id_lampiran = 0;
    }

    $data['produk'] = ProdukHukum::select('produk_hukum.*', 'satuan_kerja.nama as satker', 'status_produk.status_produk', 'status_produk.label', 'jenis_produk_hukum.jenis_produk_hukum', 'pejabat_penetap.pejabat_penetap')
      ->Leftjoin('satuan_kerja', 'satuan_kerja.id', '=', 'produk_hukum.fid_satker')
      ->Leftjoin('status_produk', 'status_produk.id', '=', 'produk_hukum.fid_status')
      ->Leftjoin('jenis_produk_hukum', 'jenis_produk_hukum.id', '=', 'produk_hukum.fid_jenis_produk_hukum')
      ->Leftjoin('pejabat_penetap', 'pejabat_penetap.id', '=', 'produk_hukum.pejabat_penetap')
      ->where('produk_hukum.id', '=', $id)
      ->first();

    if (!empty($data['produk'])) {
      $master['tujuan-disposisi'] = User::where('hak_akses', '!=', 1)
        ->where('hak_akses', '<', 5)
        ->where('hak_akses', '>', Session::get('useractive')->hak_akses)
        ->orderBy('hak_akses')
        ->get();

      $master['tujuan-revisi'] = User::where('hak_akses', '>', 1)
        ->where('hak_akses', '<', 5)
        ->where('id', '!=', Session::get('useractive')->id)
        ->orWhere('id', '=', $data['produk']->fid_user)
        ->orderBy('hak_akses')
        ->get();
    }

    $data['kendali-detil'] = KendaliUsulan::find($id_kendali);
    $data['kendali'] = $this->get_kendali($id);

    $data['lampiran'] = Lampiran::select('lampiran.*', 'users.nama as uploader', 'users.id as id_uploader')
      ->LeftJoin('users', 'users.id', '=', 'lampiran.fid_uploader')
      ->where('fid_produk_hukum', $id)
      ->get();
    $data['lampiran-detil'] = Lampiran::find($id_lampiran);

    $master['jenis-produk-hukum'] = JenisProdukHukum::get();
    $master['pejabat-penetap'] = PejabatPenetap::get();
    $master['jenis-kendali'] = $this->jenis_kendali_usulan();

    $data['otoritas'] = $this->otoritas_kendali($id);

    return view('usulan.detail.index')
      ->with('data', $data)
      ->with('master', $master)
      ->with('id_kendali', $id_kendali)
      ->with('id_lampiran', $id_lampiran)
      ->with('id', $id);
  }

  public function hapus_kendali($id)
  {
    $produk_hukum = ProdukHukum::find($id);
    if (!empty($produk_hukum)) {
      $kendali = KendaliUsulan::where('fid_produk_hukum', $id)->get();
      foreach ($kendali as $key => $value) {
        if (!empty($value->attachment)) {
        //   unlink(storage_path('app/' . $value->attachment));
        }
        $delete = KendaliUsulan::find($value->id);
        $delete->delete();
      }
    }
  }
  //testing upload dropzone
  public function file_upload(Request $request)
  {
    dd($request->file('files'));
  }
  
  public function proses_produk(Request $request)
  {
    if ($request->action == 'delete') {
      $field = ProdukHukum::find($request->id);
      $field->delete();
      if (!empty($field->attachment)) {
        unlink(storage_path('app/' . $field->attachment));
      }
      $this->hapus_kendali($request->id);
      return redirect('usulan')
        ->with('message', 'Usulan Produk Hukum berhasil dihapus')
        ->with('message_type', 'success');
    }
    if ($request->action == 'update_status') {
        DB::table('produk_hukum')
                ->where('id', $request->id)
                ->update(['deleted_at' => null]);
      return redirect('usulan')
        ->with('message', 'Usulan Produk Hukum berhasil dipulihkan')
        ->with('message_type', 'success');
    }
    $messages = [
      'judul.required' => 'Judul wajib diisi',
      'jenis.required' => 'Jenis wajib diisi',
      'pejabat_penetap.required' => 'Pejabat Penetap wajib diisi',
      'deskripsi.required' => 'Deskripsi wajib diisi',
      'attachment.mimes' => 'Draft Harus Format DOC atau DOCX',
      'attachment.required_without' => 'Draft Tidak Boleh Kosong',
      'link_attachment.required_without' => 'Link Tidak Boleh Kosong',
      'kategori_katprod.required' => 'Kategori Wajib diisi'
    ];
    $this->validate($request, [
      'judul' => 'required',
      'jenis' => 'required',
      'pejabat_penetap' => 'required',
      'deskripsi' => 'required',

      'kategori_katprod' => 'required'
    ], $messages);

    if ($request->action == "'add'") {
      $field = new ProdukHukum;
      $field->fid_status = 1;
      $field->fid_user = Session::get('useractive')->id;
      $field->fid_satker = Session::get('useractive')->fid_satker;
      $field->tanggal_usulan = date('Y-m-d H:i:s');
      $field->tahun = Session::get('yearactive');
    } else {
      $field = ProdukHukum::find($request->id);
    }
    $field->judul = $request->judul;
    $field->fid_jenis_produk_hukum = $request->jenis;
    $field->kategori_katprod = $request->kategori_katprod;
    $field->pejabat_penetap = $request->pejabat_penetap;
    $field->deskripsi = $request->deskripsi;

    if ($request->hasFile('attachment')) {
      $uploadedFile = $request->file('attachment');
      $path = $uploadedFile->store('produk_hukum');
      $field->attachment = $path;
    }

    if ($request->link_attachment) {
      $field->link_attachment = $request->link_attachment;
    }

    $field->no_pj = $request->no_pj;
    $field->nama_pj = $request->nama_pj;

    $field->save();
    $this->proses_notofikasi($field->id);
    if ($request->action == 'add') {
      $url = 'usulan/form?tab=detail&id=' . $field->id;
    } else {
      $url = 'usulan/form?tab=detail&id=' . $field->id;
    }
    return redirect($url)
      ->with('message', 'Usulan Produk Hukum berhasil disimpan')
      ->with('message_type', 'success');
  }

  public function proses_lampiran(Request $request)
  {
    if ($request->action == 'add') {
      $field = new Lampiran;
      $field->fid_produk_hukum = $request->id_usulan;
      
    } else {
      $field = Lampiran::find($request->id);
    }
    //////////////////////////////////////////////////////////////////////// setujui
    if ($request->action == 'setujui') {
      if ($field->setujui == 0) {
        $field->setujui = 1;
        $this->log('L',$field->id,$field->fid_produk_hukum,'Lampiran Usulan Produk Hukum berhasil tidak disetujui');
      } else {
        $field->setujui = 0;
        $this->log('L',$field->id,$field->fid_produk_hukum,'Lampiran Usulan Produk Hukum berhasil disetujui');
      }
    } else {
      $field->fid_uploader = $request->id_uploader;
      $field->judul = $request->judul;
      $field->keterangan = $request->keterangan;
    }
    //////////////////////////////////////////////////////////////////////////////
    if ($request->hasFile('attachment')) {
      $uploadedFile = $request->file('attachment');
      $path = $uploadedFile->store('lampiran');
      $field->attachment = $path;
    }

    if ($request->link_attachment) {
      $field->link_attachment = $request->link_attachment;
    }


    if ($request->action == 'delete') {
      $field->delete();
      $msg = 'Lampiran Usulan Produk Hukum berhasil dihapus';
      $this->log('L',$request->id,$field->fid_produk_hukum,'Lampiran Usulan Produk Hukum berhasil dihapus');
    } else {
      $field->save();
      if ($request->action == 'add') {
        $this->log('L',$field->id,$field->fid_produk_hukum,'Lampiran Usulan Produk Hukum berhasil ditambahkan');
      } else {
        $this->log('L',$request->id,$field->fid_produk_hukum,'Lampiran Usulan Produk Hukum berhasil diubah');
      }     
      $msg = 'Lampiran Usulan Produk Hukum berhasil disimpan';
      $this->notifikasi_lampiran($request->id_usulan, $request->id_uploader);
    }
    return redirect('usulan/form?tab=detail&id=' . $request->id_usulan)
      ->with('message', $msg)
      ->with('message_type', 'success');
  }

  function notifikasi_lampiran($id_usulan, $id_uploader)
  {
    $pengirim = User::find($id_uploader);
    $PH = ProdukHukum::find($id_usulan);
    ////cek di kendali apakah sudah di dispo ke staf??
    $usulan = KendaliUsulan::select('fid_tujuan')->where('fid_produk_hukum', $id_usulan)->where('fid_jenis_kendali', 1)->get();

    foreach ($usulan as $key => $value) {
      $tujuan = User::find($usulan[$key]->fid_tujuan);
      if ($tujuan->hak_akses == 4) {
        ////// kirim notifikasinya
        $url = "https://eling.semarangkota.go.id/usulan/form?tab=detail&id=" . $id_usulan;
        $notif = $pengirim->nama . " mengirim lampiran pada Produk Hukum : " . $PH->judul . "\n\n" . $url;
        $this->send_notififikasi($tujuan->phone,$notif);
      }
    }
  }

  public function get_tujuan_kendali($jenis_kendali, $id)
  {
    $produk_hukum = ProdukHukum::find($id);

    // Revisi
    // if($jenis_kendali==2){
    //   $satker=User::where('fid_satker','=',$produk_hukum->fid_satker)->first();
    //   if(!empty($satker)){
    //     $user_tujuan=$satker->id;
    //   }
    //   else{
    //     $user_tujuan=Session::get('useractive')->id;
    //   }
    // }

    //Disetujui hanya dilakukan oleh staff, kasubbag, dan kabag dengan tujuan user atasannya
    if ($jenis_kendali == 3) {
      if (Session::get('useractive')->hak_akses == 2) {
        $satker = User::where('fid_satker', '=', $produk_hukum->fid_satker)->first();
        if (!empty($satker)) {
          $user_tujuan = $satker->id;
        } else {
          $user_tujuan = Session::get('useractive')->id;
        }
      } elseif (Session::get('useractive')->hak_akses == 3) {
        $user_kabag = User::where('hak_akses', 2)->first();
        if (!empty($user_kabag)) {
          $user_tujuan = $user_kabag->id;
        } else {
          $user_tujuan = Session::get('useractive')->id;
        }
      } elseif (Session::get('useractive')->hak_akses == 4) {
        $user_kasubbag = User::where('hak_akses', 3)->first();
        if (!empty($user_kasubbag)) {
          $user_tujuan = $user_kasubbag->id;
        } else {
          $user_tujuan = Session::get('useractive')->id;
        }
      } else {
        $user_tujuan = 0;
      }
    }

    //Ajukan Draft Revisi hanya untuk tujuan siapa yang mememberikan revisi
    elseif ($jenis_kendali == 4) {
      $kendali = KendaliUsulan::where('fid_produk_hukum', $id)->where('fid_jenis_kendali', 2)->first();
      if (!empty($kendali)) {
        $user_tujuan = $kendali->fid_asal;
      } else {
        $user_tujuan = Session::get('useractive')->id;
      }
    }

    //Kendali Teruskan hanya untuk tujuan kabag
    elseif ($jenis_kendali == 5) {
      $user_kabag = User::where('hak_akses', 2)->first();
      if (!empty($user_kabag)) {
        $user_tujuan = $user_kabag->id;
      } else {
        $user_tujuan = Session::get('useractive')->id;
      }
    } elseif ($jenis_kendali == 6) {
        $user_tujuan = $produk_hukum->fid_user;
    }else {
      $user_tujuan = '';
    }
    return $user_tujuan;
  }

  public function attachment_terakhir($id, $type)
  {
    $attachment = KendaliUsulan::select('attachment')
      ->where('fid_produk_hukum', '=', $id)
      ->whereRaw('attachment IS NOT NULL')
      ->orderBy('tanggal', 'DESC')
      ->first();
    if (!empty($attachment)) {
      if ($type == "link") {
        $data = $attachment->link_attachment;
      } else {
        $data = $attachment->attachment;
      }
    } else {
      $produk_hukum = ProdukHukum::where('id', '=', $id)->first();
      if ($type == "link") {
        $data = $produk_hukum->link_attachment;
      } else {
        $data = $produk_hukum->attachment;
      }
    }
    return $data;
  }

  public function jenis_kendali_usulan()
  {
    $data = DB::table('otoritas_jenis_kendali')->select('jenis_kendali.*')
      ->join('jenis_kendali', 'jenis_kendali.id', '=', 'otoritas_jenis_kendali.fid_jenis_kendali')
      ->where('otoritas_jenis_kendali.fid_hak_akses', Session::get('useractive')->hak_akses)
      ->get();
    return $data;
  }

  public function update_status_usulan($id)
  {
    $field = ProdukHukum::find($id);
    if (!empty($field)) {
      $field->fid_status = $this->status_usulan($id);
      $field->save();
    }
  }

  public function proses_kendali(Request $request)
  {
    if ($request->action == 'add') {
      $field = new KendaliUsulan;
      $field->fid_produk_hukum = $request->id_usulan;
      $field->fid_asal = Session::get('useractive')->id;
    } else {
      $field = KendaliUsulan::find($request->id);
    }

    $cek = KendaliUsulan::where('fid_produk_hukum', $request->id_usulan)->orderBy('tanggal', 'DESC')->first();
    if (!empty($cek)) {
      $set_update = KendaliUsulan::find($cek->id);
      $set_update->status_usulan = "2";
      $set_update->save();
      //new status
      if ($request->jenis_kendali != "3") {
        $field->status_usulan = "1";
      } else {
        $field->status_usulan = "2";
      }
    } else {
      $field->status_usulan = "1";
    }
    $field->tanggal = date('Y-m-d H:i:s');
    $field->fid_jenis_kendali = $request->jenis_kendali;
    $field->catatan = $request->catatan;

    if ($request->jenis_kendali == 1) {
      $field->fid_tujuan = $request->tujuan_disposisi;
    } elseif ($request->jenis_kendali == 2) {
      $field->fid_tujuan = $request->tujuan_revisi;
    } else {
      $field->fid_tujuan = $this->get_tujuan_kendali($request->jenis_kendali, $request->id_usulan);
    }

    if ($request->hasFile('attachment')) {
      $uploadedFile = $request->file('attachment');
      $path = $uploadedFile->store('kendali');
      $field->attachment = $path;
    } else {
      if ($field->fid_produk_hukum != 0 || !empty($field->fid_produk_hukum)) {
        $attachment = $this->attachment_terakhir($field->fid_produk_hukum, "file");
        $field->attachment = $attachment;
      }
    }

    if ($request->link_attachment) {
      $field->link_attachment = $request->link_attachment;
    } else {
      if ($field->fid_produk_hukum != 0 || !empty($field->fid_produk_hukum)) {
        $attachment = $this->attachment_terakhir($field->fid_produk_hukum, "link");
        $field->link_attachment = $attachment;
      }
    }

    if ($request->action == 'delete') {
      $field->delete();
      $this->log('K',$request->id,$field->fid_produk_hukum,'Kendali Usulan Produk Hukum berhasil dihapus');
      $this->update_status_usulan($request->id_usulan);
      return redirect('usulan/form?tab=detail&id=' . $request->id_usulan)
        ->with('message', 'Kendali Usulan Produk Hukum berhasil dihapus')
        ->with('message_type', 'success');
    } else {
      $field->save();
      if ($request->action = 'add') {
        $this->log('K',$field->id,$field->fid_produk_hukum,'Kendali Usulan Produk Hukum berhasil ditambahkan');
      }else{
        $this->log('K',$field->id,$field->fid_produk_hukum,'Kendali Usulan Produk Hukum berhasil diubah');
      }
      $this->update_status_usulan($request->id_usulan);
      $this->proses_notofikasi($request->id_usulan);
      return redirect('usulan/form?tab=detail&id=' . $request->id_usulan)
        ->with('message', 'Kendali Usulan Produk Hukum berhasil disimpan')
        ->with('message_type', 'success');
    }
  }

  public function set_perintah_notifikasi($id)
  {
    $kendali = KendaliUsulan::select('kendali_usulan.*', 'satuan_kerja.nama as nama_satker', 'jenis_kendali.perintah', 'jenis_kendali.perintah_notifikasi', 'produk_hukum.judul')
      ->join('produk_hukum', 'produk_hukum.id', '=', 'kendali_usulan.fid_produk_hukum')
      ->join('satuan_kerja', 'satuan_kerja.id', '=', 'produk_hukum.fid_satker')
      ->join('jenis_kendali', 'jenis_kendali.id', '=', 'kendali_usulan.fid_jenis_kendali')
      ->find($id);
    if (!empty($kendali)) {
      $master_controller = new MasterController;
      $user_asal = $master_controller->userDetil($kendali->fid_asal);
      $user_tujuan = $master_controller->userDetil($kendali->fid_tujuan);
      if (empty($user_tujuan)) {
        $user_tujuan = new User;
        $user_tujuan->nama = '';
      }
      $perintah = str_replace('Asal', $user_asal->nama, $kendali->perintah);
      $perintah = str_replace('Tujuan', $user_tujuan->nama, $perintah);
      $perintah = str_replace('Judul', $kendali->judul, $perintah);
      $perintah = str_replace('<span style="font-weight:bold">', '', $perintah);
      $perintah = str_replace('</span>', '', $perintah);

      if ($kendali->fid_jenis_kendali == 3) {
        if ($user_tujuan->hak_akses == 5) {
          return $perintah . ", Harap segera dicetak untuk diparaf oleh pimpinan \r\n - Catatan : " . $kendali->catatan . "-";
        } else {
          return $perintah . ", " . $kendali->catatan . "-";
        }
      } else {
        return $perintah . " \r\n - Catatan : " . $kendali->catatan . "-";
      }
    }
  }
    //wa testing
    public function test(){
        dd($this->send_notififikasi('+6281225808585','Test WhatsApp ELING Semarang'));
    }
  public function send_notififikasi($tujuan, $msg)
  {
    $key = '305eee8d6ee13884f06595176ceb3fbe164873c2969a2356';
    $url = 'http://116.203.92.59/api/send_message';
    $data = array(
      "phone_no" => $tujuan,
      "key"    => $key,
      "message"  => $msg
    );
    $data_string = json_encode($data);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 360);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt(
      $ch,
      CURLOPT_HTTPHEADER,
      array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string)
      )
    );
    $res = curl_exec($ch);
    curl_close($ch);
  }

  public function proses_notofikasi($id)
  {
    $field = new Notifikasi;
    $field->id_produk = $id;
    $field->tanggal = date('Y-m-d H:i:s');
    $field->status = 0;
    $kendali = KendaliUsulan::where('fid_produk_hukum', $id)->orderBy('tanggal', 'DESC')->first();
    if (!empty($kendali)) {
      $field->tujuan = $kendali->fid_tujuan;
        $field->pesan = $this->set_perintah_notifikasi($kendali->id);
    } else {
      $users = User::where('hak_akses', 1)->first();
      $produk_hukum = ProdukHukum::select('produk_hukum.*', 'satuan_kerja.nama as nama_satker')
        ->join('satuan_kerja', 'satuan_kerja.id', '=', 'produk_hukum.fid_satker')
        ->find($id);
      $field->tujuan = $users->id;
      $field->pesan = $produk_hukum->nama_satker . ' Mengusulkan Draft Produk Hukum ' . $produk_hukum->judul . ', segera teruskan kepada kepala bagian untuk segera diproses';
    }
    $field->save();

    $user_tujuan = User::find($field->tujuan);

    $url = 'https://eling.semarangkota.go.id/usulan/form?tab=detail&id=' . $id;
    $url_setuju_kabag = 'https://eling.semarangkota.go.id/produk/detil?id=' . $id;
    if (!empty($kendali) && $kendali->fid_jenis_kendali == 3) {
      if ($user_tujuan->hak_akses == 5) {
        $field->pesan = $field->pesan . '\r\n' . $url_setuju_kabag;

        //kirim ke admin juga
        $pesan_admin = $field->pesan;
        $pesan_admin = str_replace('Harap segera dicetak untuk diparaf oleh pimpinan', 'Harap segera diregister', $pesan_admin);

        $admin = User::where('hak_akses', 1)->first();
        $this->send_notififikasi($admin->phone, $pesan_admin);
        // end kirim ke admin

      } else {
        $field->pesan = $field->pesan . '\r\n' . $url;
      }
    } else {
      $field->pesan = $field->pesan . '\r\n' . $url;
    }

    $this->send_notififikasi($user_tujuan->phone, $field->pesan);
  }

  //log lampiran dan kendali usulan
  public function log($type,$id,$id_produk,$keterangan)
  {
    $new = new Log;
    $new->user_log = Session::get('useractive')->id;
    if($type=="K"){
      $new->kendali_log = $id;
    }else{
      $new->lampiran_log = $id;
    }
    $new->produk_log = $id_produk;
    $new->ket_log = $keterangan;
    $new->save();
  }
}