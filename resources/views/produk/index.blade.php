@php($page='produk')
@php($subpage='tampil')
@include('include.function')
@php
use Illuminate\Support\Facades\Session;
$user=Session::get('useractive');
$status_usulan=Session::get('status_usulan');
@endphp
@extends('layout.main')
@section('title')
  Produk Hukum | ELING KOTA SEMARANG
@endsection
@section('css')
  {{-- <style>
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
  </style> --}}
@endsection

{{-- load page title --}}
@section('page-title')
    Produk Hukum
@endsection
{{-- end load page title --}}

{{-- load page breadcrumb --}}
@section('page-breadcrumb')
  <!--begin::Item-->
  <li class="breadcrumb-item text-white opacity-75">
    <a href="#" class="text-white text-hover-primary">Home</a>
  </li>
  <!--end::Item-->
  <!--begin::Item-->
  <li class="breadcrumb-item">
    <span class="bullet bg-white opacity-75 w-5px h-2px"></span>
  </li>
  <!--end::Item-->
  <!--begin::Item-->
  <li class="breadcrumb-item text-white opacity-75">Produk Hukum</li>
  <!--end::Item-->
@endsection
{{-- end load page breadcrumb --}}

@section('content')
<div class="col-xl-12">
  <div class="card card-xl-stretch">
      <div class="card-body">
        <div class="row mb-10">
            <!--begin::Search-->
            @include('include.search_table')
            <!--end::Search-->
            <table class="table table-striped table-row-bordered align-middle gy-5 gs-7" id="tabel_produk">
              <thead class="fw-bolder">
                <tr>
                  <th width="50px" data-priority="1">No</th>
                  <th>Nomor / Judul Produk Hukum</th>
                  <th>Satuan Kerja</th>
                  <th>Jenis Produk Hukum</th>
                  <th>Pejabat Penetap</th>
                  <th>Status</th>
                  <th width="50px"></th>
                </tr>
              </thead>
              <tbody class="fw-bold">
                @foreach ($data['produk'] as $key => $value)
                  <tr>
                    <td>{{ $key +1}}</td>
                    <td>
                      @if(!empty($value->nomor))<span>Nomor : {{$value->nomor}}</span>@else<span>BELUM REGISTRASI NOMOR</span>@endif
                      <br><span style="font-weight:bold">{{$value->judul}}</span>
                    </td>
                    <td>{{$value->satker}}</td>
                    <td>{{$value->jenis_produk_hukum}}</td>
                    <td>{{$value->pejabat_penetap}}</td>
                    <td>{!!(!empty($value->nomor) ? '<button class="btn btn-success">Sudah Registrasi</button>'  : '<button class="btn btn-danger">Belum Registrasi</button>')!!}</td>
                    <td style="text-align:right">
                      <a href="{{url('produk/detil?id='.$value->id)}}" class="btn btn-danger btn-xs"><i class="fa fa-search"></i></a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
        </div>
      </div>
  </div>
</div>
@endsection
@section('js')
  <script>
  $(function () {
    var to;
    $.get("{{url('api/satker_modal')}}",function (result) {
      console.log(result);
      $('#treeSatker').jstree({
          "core" : {
              "themes" : {
                  "responsive": true
              },
              "check_callback" : true,
              'data': result
          },
          "types" : {
              "default" : {
                  "icon" : "fa fa-folder m--font-brand"
              },
              "file" : {
                  "icon" : "fa fa-file  m--font-brand"
              }
          },
          "plugins" : [ "search", "types" ],
          "search" : { "show_only_matches" : true }
      }).on("select_node.jstree", function (e, data) {
         window.location.href = '{{ url('produk?satker=') }}'+data.node.original.id;
      });
    });
    $('#searchSatker').keyup(function () {
        if(to){
          clearTimeout(to);
        }
        to = setTimeout(function () {
            var v = $('#searchSatker').val();
            $('#treeSatker').jstree(true).search(v);
        }, 250);
    });
  });
  
  $(document).ready(function() {
    var table = $('#tabel_produk').DataTable({
      responsive: true
    });
    $('#smt-search').on( 'keyup', function () {
          table.search( this.value ).draw();
      });
  });

  </script>
@endsection
