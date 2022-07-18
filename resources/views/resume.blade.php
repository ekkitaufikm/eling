@php($page='resume')
@php($subpage='tampil')
@include('include.function')
@php
use Illuminate\Support\Facades\Session;


@endphp
@extends('layout.main')
@section('title')
  Resume Activity | ELING KOTA SEMARANG
@endsection
@section('css')

@endsection
@section('content')
<div class="page-header page-header-xs panel border-top-warning" style="padding-bottom: 0;">
	<div class="page-header-content">
		<div class="page-title">
			<h5><i class="icon-alarm-check position-left"></i> <span class="text-semibold">RESUME ACTIVITY</span></h5>
		</div>
	</div>
	<div class="breadcrumb-line breadcrumb-line-wide bg-danger" style="box-shadow: none; ">
		<ul class="breadcrumb">
			<li><a href="{{url('')}}"><i class="icon-home2 position-left"></i> Home</a></li>
			<li class="active">Resume Activity</li>
		</ul>
	</div>
  <div class="row">
		<div class="col-md-12">
			<div class="panel-body">
				<div class="tabbable">
          <form action="{{url('resume/set_data')}}" method="post">
            {{ csrf_field() }}
            <div class="row">
              {{-- @if(Session::get('useractive')->hak_akses==2)
              <div class="col-md-3">
                <div class="form-group">
                  <label>Hak Akses User</label>
                  <select name="tujuan" class="select2">
                    @foreach ($master['hak-akses'] as $key => $value)
                      <option value="{{$value->id}}" @if($user==$value->id) selected @endif >{{$value->hak_akses}}</option>
                    @endforeach
          				</select>
                </div>
              </div>
              @endif --}}
              <div class="col-md-3">
                <div class="form-group">
                  <label>Jenis Kendali</label>
                  <select name="jenis" class="select2" onchange="javascript:submit()">
                    @foreach ($master['jenis-resume'] as $key => $value)
                      <option value="{{$value->id}}" @if($jenis==$value->id) selected @endif >{{$value->jenis_resume}}</option>
                    @endforeach
          				</select>
                </div>
              </div>
            </div>
          </form>
          <hr>
          <div style="margin:10px 0px 10px 0px;font-size:20px;background:#d4d4d4;padding:20px">{{$master['perintah-resume']->perintah}}</div>
          <table class="table table-bordered table-hover">
            <thead>
              @if($jenis==3 || $jenis==4 || $jenis==5 || $jenis==6)
              <tr>
                <th width="50px">No</th>
                <th>Nomor / Tanggal<br>Surat Usulan</th>
                <th>Judul Produk Hukum</th>
                <th>Jenis Produk Hukum</th>
                <th>Satuan Kerja</th>
                <th width="20px"></th>
              </tr>
              @else
              <tr>
                <th width="50px">No</th>
                <th>Nomor dan Tanggal Surat</th>
                <th>Perihal</th>
                <th>Asal Surat</th>
                <th width="20px"></th>
              </tr>
              @endif
            </thead>
            <tbody>
              @if($jenis==3 || $jenis==4 || $jenis==5 || $jenis==6)
                @foreach ($data as $key => $value)
                  <tr>
                    <td>{{$key+1}}</td>
                    <td style="white-space:nowrap"><b>{{$value->nomor_surat}}</b><br>{{tgl_indo($value->tanggal_surat)}}</td>
                    <td>{{$value->judul}}</td>
                    <td>{{$value->jenis_produk_hukum}}</td>
              			<td>{{$value->satker}}</td>
                    <td><a href="{{url('usulan/form/kendali/'.$value->fid_usulan.'/'.$value->id)}}" class="btn btn-primary btn-xs"><i class=" icon-search4"></i></a></td>
                  </tr>
                @endforeach
              @else
                @foreach ($data as $key => $value)
                  <tr>
                    <td>{{$key+1}}</td>
                    <td style="white-space:nowrap">
                      <div style="font-weight:bold">{{$value->nomor_surat}}</div>
                      {{tgl_indo($value->tanggal_surat)}}
                    </td>
                    <td>{{$value->perihal}}</td>
              			<td>{{$value->satker}}</td>
                    @if($jenis==1)
                    <td><a href="{{url('usulan/form/surat/'.$value->id)}}" class="btn btn-primary btn-xs"><i class=" icon-search4"></i></a></td>
                    @else
                    <td><a href="{{url('usulan/form/disposisi/'.$value->id)}}" class="btn btn-primary btn-xs"><i class=" icon-search4"></i></a></td>
                    @endif
                  </tr>
                @endforeach
              @endif
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
