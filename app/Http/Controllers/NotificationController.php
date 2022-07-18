<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Notification;
use App\User;
use App\KendaliUsulan;
use App\HakAkses;

class NotificationController extends Controller
{
    public function createNotification($jenis,$kendali,$usulan){
      if($jenis=='Terima Surat'){
        $get_kabag=User::where('hak_akses','=',2)->where('tahun','=',Session::get('yearactive'))->first();
        $send=new Notification;
        $send->tanggal=date('Y-m-d');
        $send->waktu=date('H:i:s');
        $send->fid_usulan=$usulan;
        $send->pesan='Administrator telah menerima surat usulan produk hukum, Harap segera di Disposisi';
        $send->fid_tujuan=$get_kabag->id;
        $send->status=0;
        $send->save();
      }
      else{
        $kendali_produk=KendaliUsulan::select('kendali_usulan.*','jenis_kendali.perintah','produk_hukum.judul')
          ->Leftjoin('produk_hukum','produk_hukum.id','=','kendali_usulan.fid_produk_hukum')
          ->Leftjoin('jenis_kendali','jenis_kendali.id','=','kendali_usulan.fid_jenis_kendali')
          ->where('kendali_usulan.id','=',$kendali)
          ->first();

        $master_controller=new MasterController;
        $asal=$master_controller->userDetil($kendali_produk->fid_asal);
        $tujuan=$master_controller->userDetil($kendali_produk->fid_tujuan);

        $pesan=str_replace('Asal',$asal->nama,$kendali_produk->perintah);
        $pesan=str_replace('untuk Tujuan','',$pesan);
        $pesan=str_replace('kepada Tujuan','',$pesan);
        $pesan=str_replace('Produk Hukum','Produk Hukum yang berjudul '.$kendali_produk->judul,$pesan);

        $send=new Notification;
        $send->tanggal=date('Y-m-d');
        $send->waktu=date('H:i:s');
        $send->fid_usulan=$usulan;
        $send->pesan=$pesan;
        $send->fid_tujuan=$kendali_produk->fid_tujuan;
        $send->status=0;
        $send->save();
      }

    }

    public function dateFormat($date,$format){
      $date=date_create($date);
      $date_new=date_format($date,$format);
      return $date_new;
    }

    public function getNotifikasi($day,$tujuan){
      $data=Notification::select('notifikasi.*','users.nama')
                          ->join('users','users.id','=','notifikasi.fid_tujuan')
                          ->where('tanggal','=',$this->dateFormat($day,'Y-m-d'))
                          ->orderBy('tanggal','DESC')->orderBy('waktu','DESC');
      if(Session::get('useractive')->hak_akses==1 || Session::get('useractive')->hak_akses==2){
        if($tujuan=='default'){
          $data=$data->where('hak_akses','=',2);
        }
        else{
          $data=$data->where('hak_akses','=',$tujuan);
        }
      }
      else{
        $data=$data->where('fid_tujuan','=',Session::get('useractive')->id);
      }

      $data=$data->get();

      return $data;
    }

    public function setData(Request $request){
      if(!isset($request->tujuan)){
        return redirect('notifikasi/'.$request->day);
      }
      else{
        return redirect('notifikasi/'.$request->day.'/'.$request->tujuan);
      }
    }



    public function index($day='default',$tujuan='default'){
      if($day=='default'){
        $day=date('d-m-Y');
      }
      else{
        $day=$day;
      }

      $master['hak-akses']=HakAkses::where('id','!=','1')->get();
      $data=$this->getNotifikasi($day,$tujuan);
      return view('notifikasi')
        ->with('master',$master)
        ->with('day',$day)
        ->with('tujuan',$tujuan)
        ->with('data',$data);
    }
}
