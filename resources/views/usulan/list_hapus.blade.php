@php($page='usulan')
@php($subpage='tampil')
@include('include.function')
@php
use Illuminate\Support\Facades\Session;
$user=Session::get('useractive');
$status_usulan=Session::get('status_usulan');
@endphp
@extends('layout.main')
@section('title')
Usulan Produk Hukum | ELING KOTA SEMARANG
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

.tabbable ul li.active {
    background-color: #f44336;
    color: white;
}
</style> --}}
@endsection

{{-- load page title --}}
@section('page-title')
    Usulan Produk Hukum
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
  <li class="breadcrumb-item text-white opacity-75">Usulan Produk Hukum</li>
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
               <table class="table table-striped table-row-bordered align-middle gy-5 gs-7" id="tabel_usulan">
                <thead class="fw-bolder">
                    <tr>
                        <th width="50px" data-priority="1">No</th>
                        <th>Tanggal Usulan</th>
                        <th>Judul Produk Hukum</th>
                        <th>Satuan Kerja</th>
                        <th>Jenis Produk Hukum</th>
                        <th>Pejabat Penetap</th>
                        <th>Status</th>
                        <th width="50px"></th>
                    </tr>
                </thead>
                <tbody class="fw-bold">
                    @foreach ($data['usulan2'] as $key => $value)
                    @php
                    // if($value->isdone == "0"){
                    // continue;
                    // }
                    @endphp
                    <tr>
                        <td>{{ $key +1}}</td>
                        <td style="white-space:nowrap">{{tgl_indo($value->tanggal_usulan)}}</td>
                        <td style="font-weight:bold"><a
                                href="{{url('usulan/form?tab=detail&id='.$value->id)}}">{{$value->judul}}</a></td>
                        <td>{{$value->satker}}</td>
                        <td>{{$value->jenis_produk_hukum}}</td>
                        <td>{{$value->pejabat_penetap}}</td>
                        <td>
                            <button class="btn btn-sm text-white" style="background:{{$value->label}}">{{$value->status_produk}}</button>
                        </td>
                        <td style="text-align:right">
                            <div class="btn-group">
                                <button data-bs-toggle="dropdown" class="btn btn-danger btn-xs dropdown-toggle"
                                    aria-expanded="false"><span class="caret"></span> Aksi</button>
                                <ul class="dropdown-menu pull-right">
                                    <a href="javascript:;" onclick="confirmUpdate('{{$value->id}}')"
                                        class="dropdown-item update-usulan">PULIHKAN USULAN</a>
                                    <form action="{{url('usulan/produk/proses')}}" method="post"
                                        id="update_status{{$value->id}}">{{ csrf_field()}}
                                        <input type="hidden" name="action" value="update_status">
                                        <input type="hidden" name="id" value="{{$value->id}}">
                                    </form>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
          </div>
        </div>
    </div>
</div>
{{-- <div class="card card-xl-stretch">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
         
        </div>
        <div class="page-header page-header-xs panel border-top-warning" style="padding-bottom: 0;">
            <div class="container">
              
            </div>
        </div>
        <div id="modal-filter" class="modal fade right">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="tabbable">
                            <ul class="nav nav-tabs nav-tabs-bottom bottom-divided nav-justified">
                                <li class="active"><a href="#tab-satker" data-toggle="tab">Satuan Kerja</a></li>
                                <li><a href="#tab-filter" data-toggle="tab">Filter</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-satker">
                                    <input class="form-control" type="text" id="searchSatker" placeholder="Cari Satuan Kerja">
                                    <hr>
                                    <div id="treeSatker" class="tree-demo"></div>
                                </div>
                                <div class="tab-pane" id="tab-filter">
                                    <form action="" method="get">
                                        @if($satker!='all')<input type="hidden" name="satker" value="{{$satker}}">@endif
                                        <div class="form-group">
                                            <label>Status Usulan </label>
                                            <select class="select2" name="status">
                                                <option value="all" @if($status=='all' ) selected @endif>SEMUA STATUS</option>
                                                @foreach ($data['status-usulan'] as $key => $value)
                                                <option value="{{$value->id}}" @if($value->id==$status) selected
                                                    @endif>{{$value->status_produk}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-warning btn-block">SIMPAN</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!-- /basic modal -->
@endsection
@section('js')
<script>
$(function() {
    var to;
    $.get("{{url('api/satker_modal')}}", function(result) {
        console.log(result);
        $('#treeSatker').jstree({
            "core": {
                "themes": {
                    "responsive": true
                },
                "check_callback": true,
                'data': result
            },
            "types": {
                "default": {
                    "icon": "fa fa-folder m--font-brand"
                },
                "file": {
                    "icon": "fa fa-file  m--font-brand"
                }
            },
            "plugins": ["search", "types"],
            "search": {
                "show_only_matches": true
            }
        }).on("select_node.jstree", function(e, data) {
            @if($status == 'all')
            window.location.href = '{{ url('usulan ? satker = ') }}' + data.node.original.id;
            @else
            window.location.href = '{!! url('usulan ? status = '.$status.' & satker = ') !!}' + data.node.original.id;
            @endif
        });
    });
    $('#searchSatker').keyup(function() {
        if (to) {
            clearTimeout(to);
        }
        to = setTimeout(function() {
            var v = $('#searchSatker').val();
            $('#treeSatker').jstree(true).search(v);
        }, 250);
    });
});

$(document).ready(function() {
    var table = $('#tabel_usulan').DataTable({
      responsive: true
    });
    $('#smt-search').on( 'keyup', function () {
          table.search( this.value ).draw();
      });
});
</script>
@endsection