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
    <!--begin::Item-->
    <li class="breadcrumb-item">
        <span class="bullet bg-white opacity-75 w-5px h-2px"></span>
    </li>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="breadcrumb-item text-white opacity-75">Usulan</li>
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

.list-produk {
    border-bottom: 1px #ccc solid;
    padding-bottom: 10px;
    margin-top: 10px
}

.list-produk a {
    color: #1c1c1c;
    line-height: 15px;
    margin-bottom: 10px
}

.list-produk a:hover {
    color: #d75a00
}

.less-margin {
    margin-top: 5px;
    margin-bottom: 5px;
}
</style> --}}
@endsection
@section('content')
<div class="col-xl-12">
    <div class="card card-xl-stretch">
        <div class="card-body">
            <div class="row mb-10">
                
                <!--begin::Navs-->
                @if($id!=0)
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder">
                    <!--begin::Nav item-->
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 @if($tab=='produk') active @endif" @if($id!='all') href="{{ url('usulan/form?tab=produk&id='.$id) }} @endif">Produk Hukum</a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 @if($tab=='detail') active @endif" @if($id!='all') href="{{ url('usulan/form?tab=detail&id='.$id) }} @endif">Lampiran & Kendali Produk Hukum</a>
                    </li>
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    @if ($user->hak_akses=="1" || $user->hak_akses=="2" || $user->hak_akses=="3" ||
                    $user->hak_akses=="4")
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 @if($tab=='detail_log') active @endif" @if($id!='all') href="{{ url('usulan/form?tab=detail_log&id='.$id) }}" @endif>Log Lampiran & Kendali Produk Hukum</a>
                    </li>
                    @endif
                    <!--end::Nav item-->
                </ul>
                @endif
                <!--begin::Navs-->

                @include('usulan.form.'.$tab)
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
$("#jenis_kendali").change(function() {
    if ($(this).val() == 1) {
        $('#tujuan_disposisi').show();
        $('#tujuan_revisi').hide();
    } else if ($(this).val() == 2) {
        $('#tujuan_revisi').show();
        $('#tujuan_disposisi').hide();
    } else {
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

function hidelampiran() {
    var y = document.getElementById("lampiran");
    if (y.style.display === "block") {
        y.style.display = "none";
    } else {
        y.style.display = "block";
    }
}
</script>
@endsection