@php($page='laporan')
@php($subpage='laporan')
@include('include.function')
@php
use Illuminate\Support\Facades\Session;
$user=Session::get('useractive');
@endphp
@extends('layout.main')
@section('title')
  Laporan Produk Hukum | ELING KOTA SEMARANG
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
  </style> --}}
@endsection

{{-- load page title --}}
@section('page-title')
    Laporan Produk Hukum
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
  <li class="breadcrumb-item text-white opacity-75">Laporan Produk Hukum</li>
  <!--end::Item-->
@endsection
{{-- end load page breadcrumb --}}

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
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 @if(request()->query('tab')=="jenis" || empty(request()->query('tab'))) active @endif" href="{{ url('laporan?tab=jenis') }}">Jenis Produk Hukum</a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 @if(request()->query('tab')=="status") active @endif" href="{{ url('laporan?tab=status') }}">Status Usulan Produk Hukum</a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5 @if(request()->query('tab')=="bulanan") active @endif" href="{{ url('laporan?tab=bulanan') }}">Rekap Bulanan</a>
                </li>
                <!--end::Nav item-->
              </ul>
              <!--begin::Navs-->
              {{-- main table --}}

              @include('laporan.'.$tab)
          </div>
      </div>
  </div>
</div>


@endsection
@section('js')

@endsection
