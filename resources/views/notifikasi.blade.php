@php($page='notifikasi')
@php($subpage='tampil')
@include('include.function')
@php
use Illuminate\Support\Facades\Session;
$user=Session::get('useractive');
$status_usulan=Session::get('status_usulan');
@endphp
@extends('layout.main')
@section('title')
  Notifikasi | ELING KOTA SEMARANG
@endsection
@section('css')

@endsection

{{-- load page title --}}
@section('page-title')
    Notifikasi
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
  <li class="breadcrumb-item text-white opacity-75">Notifikasi</li>
  <!--end::Item-->
@endsection
{{-- end load page breadcrumb --}}

@section('content')
<div class="col-xl-12">
  <div class="card card-xl-stretch">
    <div class="card-body">
      <div class="row mb-10">
        <div class="table-responsive">
          <table class="table table-striped table-row-bordered align-middle gy-5 gs-7" id="tabel_satker">
            <thead class="fw-bolder">
              <tr>
                <th width="50px">No</th>
                <th>Tanggal dan Waktu</th>
                <th>Pesan Notifikasi</th>
                <th width="20px"></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data['notifikasi'] as $key => $value)
                <tr>
                  <td>{{$key+1}}</td>
                  <td style="white-space:nowrap"><b>{{tgl_indo($value->tanggal)}}</b><br>{{dateFormat($value->tanggal,"H:i:s")}}</td>
                  <td>{!!$value->pesan!!}</td>
                  <td>
                    <a href="{{url('usulan/form?tab=kendali&id='.$value->id_produk)}}" class="btn btn-primary btn-xs"><i class="fa fa-search"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')


@endsection
