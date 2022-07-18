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
{{-- load page title --}}
@section('page-title')
    Usulan Produk Hukum
@endsection
{{-- end load page title --}}
{{-- load page breadcrumb --}}
@section('page-breadcrumb')
  <!--begin::Item-->
  <li class="breadcrumb-item text-white opacity-75">
      <a href="#" class="text-white text-hover-primary">Usulan Produk Hukum</a>
  </li>
  <!--end::Item-->
@endsection
{{-- end load page breadcrumb --}}
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
@section('content')
<div class="col-xl-12">
    <div class="card card-xl-stretch">
        <div class="card-body">
            <div class="row mb-10">
                {{-- menu table main --}}
                <!--begin::Navs-->
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder">
                    <!--begin::Nav item-->
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 @if(empty(request()->query('tab'))) active @endif" href="{{ url('usulan') }}">Rekap</a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 @if(request()->query('tab')=="belum") active @endif" href="{{ url('usulan?tab=belum') }}">On Process</a>
                    </li>
                    <!--end::Nav item-->
                </ul>
                <!--begin::Navs-->
                {{-- main table --}}
                <div class="col-md-12 mt-10">
                    <div class="card card-xl-stretch">
                        <div class="card-body bg-secondary">
                            <div class="row mb-10">
                                <div class="col-md-6">
                                    {{-- inclued search table --}}
                                    @include('include.search_table')
                                    {{-- end include search table --}}
                                </div>
                                <div class="col-md-6">
                                    {{-- tambah usulan produk hukum --}}
                                    {{-- @if(Session::get('useractive')->hak_akses=='5') --}}
                                    <a href="{{url('usulan/form')}}">
                                        <button type="button" class="btn btn-bg-danger float-end text-white btn-active-color-primary">
                                            <i class="fa fa-plus-square text-white text-active-primary"></i>
                                            Tambah
                                        </button>
                                    </a>
                                    {{-- @endif --}}
                                    {{-- end tambah usulan produk hukum --}}
                                </div>
                               
                              
                                {{-- table rekap --}}
                                @if (empty(request()->query('tab')))
                                <div class="table-responsive">
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
                                        <tbody id="main-bdy" class="fw-bold">
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
                                                            <a class="dropdown-item" href="{{url('usulan/form?tab=produk&id='.$value->id)}}">PRODUK HUKUM</a>
                                                            {{-- <li><a href="{{url('usulan/form?tab=lampiran&id='.$value->id)}}">LAMPIRAN</a></li>
                                                            --}}
                                                            {{-- <li><a href="{{url('usulan/form?tab=kendali&id='.$value->id)}}">KENDALI USULAN</a>
                                                            </li> --}}
                                                            <a class="dropdown-item" href="{{url('usulan/form?tab=detail&id='.$value->id)}}">LAMPIRAN & KENDALI
                                                                    USULAN</a>
                                                            
                                                            <a href="javascript:;" class="dropdown-item" onclick="confirmDelete('{{$value->id}}')"
                                                                class="hapus-usulan">HAPUS USULAN</a>
                                                            <form action="{{url('usulan/produk/proses')}}" method="post"
                                                                id="hapus{{$value->id}}">{{ csrf_field()}}
                                                                <input type="hidden" name="action" value="delete">
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
                                @endif
                                {{-- end table rekap --}}

                                {{-- table On Process --}}
                                @if (request()->query('tab')=="belum")
                                <div class="table-responsive">
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
                                        <tbody id="main-bdy" class="fw-bold">
                                            @foreach ($data['usulan2'] as $key => $value)
                                            @php
                                            if($value->isdone == "1"){
                                                continue;
                                            }
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
                                                            <a class="dropdown-item" href="{{url('usulan/form?tab=produk&id='.$value->id)}}">PRODUK HUKUM</a>
                                                            {{-- <li><a href="{{url('usulan/form?tab=lampiran&id='.$value->id)}}">LAMPIRAN</a></li>
                                                            --}}
                                                            {{-- <li><a href="{{url('usulan/form?tab=kendali&id='.$value->id)}}">KENDALI USULAN</a>
                                                            </li> --}}
                                                            <a class="dropdown-item" href="{{url('usulan/form?tab=detail&id='.$value->id)}}">LAMPIRAN & KENDALI
                                                                    USULAN</a>
                                                            
                                                            <a href="javascript:;" class="dropdown-item" onclick="confirmDelete('{{$value->id}}')"
                                                                class="hapus-usulan">HAPUS USULAN</a>
                                                            <form action="{{url('usulan/produk/proses')}}" method="post"
                                                                id="hapus{{$value->id}}">{{ csrf_field()}}
                                                                <input type="hidden" name="action" value="delete">
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
                                @endif
                                {{-- end table On Process --}}

                                {{-- table Kabag --}}
                                @if (request()->query('tab')=="kabag")
                                <div class="table-responsive">
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
                                        <tbody id="main-bdy" class="fw-bold">
                                            @foreach ($data['usulan2'] as $key => $value)
                                            @php
                                                if($value->ishak_ke != "2"){
                                                    continue;
                                                }
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
                                                            <a class="dropdown-item" href="{{url('usulan/form?tab=produk&id='.$value->id)}}">PRODUK HUKUM</a>
                                                            {{-- <li><a href="{{url('usulan/form?tab=lampiran&id='.$value->id)}}">LAMPIRAN</a></li>
                                                            --}}
                                                            {{-- <li><a href="{{url('usulan/form?tab=kendali&id='.$value->id)}}">KENDALI USULAN</a>
                                                            </li> --}}
                                                            <a class="dropdown-item" href="{{url('usulan/form?tab=detail&id='.$value->id)}}">LAMPIRAN & KENDALI
                                                                    USULAN</a>
                                                            
                                                            <a href="javascript:;" class="dropdown-item" onclick="confirmDelete('{{$value->id}}')"
                                                                class="hapus-usulan">HAPUS USULAN</a>
                                                            <form action="{{url('usulan/produk/proses')}}" method="post"
                                                                id="hapus{{$value->id}}">{{ csrf_field()}}
                                                                <input type="hidden" name="action" value="delete">
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
                                @endif
                                {{-- end table Kabag --}}

                                {{-- table Kasubag --}}
                                @if (request()->query('tab')=="kasubag")
                                <div class="table-responsive">
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
                                        <tbody id="main-bdy" class="fw-bold">
                                            @foreach ($data['usulan2'] as $key => $value)
                                            @php
                                                if($value->ishak_ke != "3"){
                                                    continue;
                                                }
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
                                                            <a class="dropdown-item" href="{{url('usulan/form?tab=produk&id='.$value->id)}}">PRODUK HUKUM</a>
                                                            {{-- <li><a href="{{url('usulan/form?tab=lampiran&id='.$value->id)}}">LAMPIRAN</a></li>
                                                            --}}
                                                            {{-- <li><a href="{{url('usulan/form?tab=kendali&id='.$value->id)}}">KENDALI USULAN</a>
                                                            </li> --}}
                                                            <a class="dropdown-item" href="{{url('usulan/form?tab=detail&id='.$value->id)}}">LAMPIRAN & KENDALI
                                                                    USULAN</a>
                                                            
                                                            <a href="javascript:;" class="dropdown-item" onclick="confirmDelete('{{$value->id}}')"
                                                                class="hapus-usulan">HAPUS USULAN</a>
                                                            <form action="{{url('usulan/produk/proses')}}" method="post"
                                                                id="hapus{{$value->id}}">{{ csrf_field()}}
                                                                <input type="hidden" name="action" value="delete">
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
                                @endif
                                {{-- end table Kasubag --}}

                                {{-- table staff --}}
                                @if (request()->query('tab')=="staff")
                                <div class="table-responsive">
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
                                        <tbody id="main-bdy" class="fw-bold">
                                            @foreach ($data['usulan2'] as $key => $value)
                                            @php
                                                if($value->ishak_ke != "4"){
                                                    continue;
                                                }
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
                                                            <a class="dropdown-item" href="{{url('usulan/form?tab=produk&id='.$value->id)}}">PRODUK HUKUM</a>
                                                            {{-- <li><a href="{{url('usulan/form?tab=lampiran&id='.$value->id)}}">LAMPIRAN</a></li>
                                                            --}}
                                                            {{-- <li><a href="{{url('usulan/form?tab=kendali&id='.$value->id)}}">KENDALI USULAN</a>
                                                            </li> --}}
                                                            <a class="dropdown-item" href="{{url('usulan/form?tab=detail&id='.$value->id)}}">LAMPIRAN & KENDALI
                                                                    USULAN</a>
                                                            
                                                            <a href="javascript:;" class="dropdown-item" onclick="confirmDelete('{{$value->id}}')"
                                                                class="hapus-usulan">HAPUS USULAN</a>
                                                            <form action="{{url('usulan/produk/proses')}}" method="post"
                                                                id="hapus{{$value->id}}">{{ csrf_field()}}
                                                                <input type="hidden" name="action" value="delete">
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
                                @endif
                                {{-- end table staff --}}
                               
                            </div>
                        </div>
                    </div>
                </div>
                {{-- main table --}}
            </div>
        </div>
        <!-- /basic modal -->
    </div>
</div>
@endsection
@section('js')
<script>
$(function() {
    var table = $('#tabel_usulan').DataTable({
        responsive: true
    });
    $('#smt-search').on( 'keyup', function () {
        table.search( this.value ).draw();
    });
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
</script>
@endsection