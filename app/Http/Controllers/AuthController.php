<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\User;

class AuthController extends Controller
{

  public function index(){
    return view('login');
  }

  public function login(Request $request){
    $check = User::where('username','=',$request->input('username'))->count();
    if($check == 1){
        $user = User::where('username','=',$request->input('username'))->first();
        if($request->password == decrypt($user->userpass)){
          Session::put('useractive',$user);
          Session::put('yearactive',$request->tahun);
          return redirect()->intended('dashboard')
            ->with('message','Login Success')
            ->with('message_type','success');
        }else{
          return redirect('login')
            ->with('message','Password Salah')
            ->with('message_type','error');
        }
    }else{
      return redirect('login')
        ->with('message','Username tidak ditemukan')
        ->with('message_type','error');
    }
  }

  public function logoutProses(){
    // Session::forget('useractive');
    Session::flush();
    return redirect('login');
  }
}
