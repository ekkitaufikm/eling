<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Satker;
use App\Kinerja;
use App\Slider;
use App\Informasi;

class ApiController extends Controller
{

  public function getUser($id){
    $data=User::find($id);
    return response()->json($data);
  }

  public function getSatker($id){
    $data=Satker::find($id);
    return response()->json($data);
  }
  public function getKinerja($id){
    $data=Kinerja::find($id);
    return response()->json($data);
  }

  public function nestedArray($source, $parent = '0'){
    $result = array();
    foreach ($source as $value) {
      if ($value['parent_kode'] == $parent) {
        $sub = $this->nestedArray($source, $value['id']);
        if ($sub) {
            $value['children'] = $sub;
        }
        $result[] = $value;
      }
    }
    return $result;
  }

  public function satkerModal(){
    $query = Satker::select('id','nama as text','parent_id as parent_kode','kode_satker')->orderBy('id','asc');
    $data = $query->get();
    $result = $this->nestedArray($data);
    return response()->json($result);
  }

  public function sliderModal($id)
  {
    $data = Slider::find($id);
    $set_ar = array(
      'id' => $data->id,
      'order' => $data->order,
      'judul' => $data->judul,
      'slider' => asset('storage/'.$data->slider)
    );
    return response()->json($set_ar);
  }

  public function infoModal($id)
  {
    $data = Informasi::find($id);
    $set_ar = array(
      'id_informasi' => $data->id_informasi,
      'judul_informasi' => $data->judul_informasi,
      'file_informasi' => asset('storage/'.$data->file_informasi)
    );
    return response()->json($set_ar);
  }
}
