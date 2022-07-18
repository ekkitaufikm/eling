@php($page='usulan')
@php($subpage='fom')
@include('include.function')
@php
use Illuminate\Support\Facades\Session;
$user=Session::get('useractive');
@endphp
@extends('layout.main')
@section('title')
  Usulan Produk Hukum | ELING KOTA SEMARANG
@endsection
@section('css')
  <style>
    .modal.right .modal-dialog {
      position: fixed;
      margin: auto;
      width: 400px;
      height: 100%;
      -webkit-transform: translate3d(0%, 0, 0);
          -ms-transform: translate3d(0%, 0, 0);
           -o-transform: translate3d(0%, 0, 0);
              transform: translate3d(0%, 0, 0);
    }

    .modal.right .modal-content {
      height: 100%;
      overflow-y: auto;
    }

    /*Right*/
    .modal.right.fade .modal-dialog {
      right: -400px;
      -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
         -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
           -o-transition: opacity 0.3s linear, right 0.3s ease-out;
              transition: opacity 0.3s linear, right 0.3s ease-out;
    }

    .modal.right.fade.in .modal-dialog {
      right: 0;
    }

    /* ----- MODAL STYLE ----- */
    .modal-content {
      border-radius: 0;
      border: none;
    }
    .list-produk{
      border-bottom:1px #ccc solid;
      padding-bottom: 10px;
      margin-top:10px
    }
    .list-produk a{
      color:#1c1c1c;
      line-height: 15px;
      margin-bottom:10px
    }
    .list-produk a:hover{
      color:#d75a00
    }
    .less-margin{
      margin-top: 5px;
      margin-bottom: 5px;
    }
  </style>
@endsection
@section('content')
<div class="page-header page-header-xs panel border-top-warning" style="padding-bottom: 0;">
	<div class="page-header-content">
		<div class="page-title">
			<h5><i class="icon-file-text2 position-left"></i> <span class="text-semibold">USULAN PRODUK HUKUM</span></h5>
		</div>
	</div>
	<div class="breadcrumb-line breadcrumb-line-wide bg-danger" style="box-shadow: none; ">
		<ul class="breadcrumb">
			<li><a href="{{url('')}}"><i class="icon-home2 position-left"></i> Home</a></li>
      <li><a class="active">Usulan</a></li>
		</ul>
	</div>
  <div class="row">
		<div class="col-md-12">
			<div class="panel-body">
        @if(empty($data['produk']) && $id!=0 )
          <div style="text-align:center">
            <img src="{{asset('assets/images/search.png')}}" style="width:250px;">
            <h4>USULAN PRODUK HUKUM TIDAK DITEMUKAN</h4>
          </div>
        @else
				<div class="tabbable">
          
          @include('usulan.detail.detail')
        </div>
        @endif
      </div>
    </div>
  </div>
</div>


@endsection
@section('js')
<script>
  $("#jenis_kendali").change(function(){
    if($(this).val()==1){
      $('#tujuan_disposisi').show();
      $('#tujuan_revisi').hide();
    }
    else if($(this).val()==2){
      $('#tujuan_revisi').show();
      $('#tujuan_disposisi').hide();
    }
    else{
      $('#tujuan_revisi').hide();
      $('#tujuan_disposisi').hide();
    }
  });
  $("#jenis_kendali").trigger('change');
  
  function hide() {
  var x = document.getElementById("toHide");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
  }

    function hidelampiran(){
        var y = document.getElementById("lampiran");
    if (y.style.display === "block") {
        y.style.display = "none";
      } else {
        y.style.display = "block";
      }
    }

  </script>
@endsection
