@php($page='produk')
@php($subpage='detil')
@include('include.function')
@php
use Illuminate\Support\Facades\Session;
$user=Session::get('useractive');
@endphp
@extends('layout.main')
@section('title')
  Produk Hukum | ELING KOTA SEMARANG
@endsection
@section('css')
<style>
.table tr:first-child td{
  border-top: none
}
</style>
@endsection
@section('content')
<div class="page-header page-header-xs panel border-top-warning" style="padding-bottom: 0;">
	<div class="page-header-content">
		<div class="page-title">
			<h5><i class="icon-law position-left"></i> <span class="text-semibold">PRODUK HUKUM</span></h5>
		</div>
	</div>
	<div class="breadcrumb-line breadcrumb-line-wide bg-danger" style="box-shadow: none; ">
		<ul class="breadcrumb">
			<li><a href="{{url('')}}"><i class="icon-home2 position-left"></i> Home</a></li>
      <li><a href="{{url('')}}">Produk</a></li>
			<li class="active">Detil</li>
		</ul>
	</div>
  <div class="row">
      
      
<!--############################################# kalau mau dibuka trackingnya ini dibuat col8 ##############################################################-->
		<div class="col-md-8">
			<div class="panel-body">
        <div class="row">
          <div class="col-md-12">
            <table class="table">
              <tbody>
                <tr>
              		<td width="180px">No. Register</td>
              		<td width="10px">:</td>
              		<td>
                    @if(Session::get('useractive')->hak_akses==1)
                    <form action="{{url('produk/register/proses')}}" method="post">
                    {{ csrf_field() }}
                    <div class="input-group">
                      <input type="input" class="form-control" name="nomor" value="{{$data['produk-hukum']->nomor}}" >
                      <span class="input-group-append">
                        <input type="hidden" name="id" value="{{$id}}">
                        <button class="btn btn-light" type="submit">SIMPAN NOMOR REGISTER</button>
                      </span>
                    </div>
                    </form>
                    @else
                      {{(!empty($data['produk-hukum']->nomor) ? $data['produk-hukum']->nomor  : 'PRODUK HUKUM BELUM DIREGISTRASI')}}
                    @endif
                    <br>
                    @if(!empty($data['produk-hukum']->nomor))
                    <a href="{{url('produk/cetak_register?id='.$id)}}" target="_blank" class="btn btn-primary btn-xs"><i class="icon-printer2 position-left"></i>CETAK BUKTI REGISTER</a>
                    @endif
                  </td>
              	</tr>
                <tr>
              		<td>Judul Produk Hukum</td>
              		<td>:</td>
              		<td>{{$data['produk-hukum']->judul}}</td>
              	</tr>
              	<tr>
              		<td>Satuan Kerja</td>
              		<td>:</td>
              		<td>{{$data['produk-hukum']->satker}}</td>
              	</tr>
                <tr>
              		<td>Jenis Produk Hukum</td>
              		<td>:</td>
              		<td>{{$data['produk-hukum']->jenis_produk_hukum}}</td>
              	</tr>
				  <tr>
					<td>Kategori Produk Hukum</td>
					<td>:</td>
					<td>{{@$data['produk-hukum']->nama_katprod}}</td>
				</tr>
                <tr>
              		<td>Pejabat Penetap</td>
              		<td>:</td>
              		<td>{{$data['produk-hukum']->pejabat_penetap}}</td>
              	</tr>
              	<tr>
              		<td>Deskripsi</td>
              		<td>:</td>
              		<td>{{$data['produk-hukum']->deskripsi}}</td>
              	</tr>
              	<tr>
              		<td>Draft Produk Hukum</td>
              		<td>:</td>
              		<td>
					@if (empty($data['produk-hukum']->link_attachment) || $data['produk-hukum']->link_attachment=="-" )
				    <a href="{{asset('storage/'.$data['produk-hukum']->attachment_fix)}}" class="btn btn-primary btn-xs" target="_BLANK"><i class="icon-download"></i> DOWNLOAD / CETAK SK</a>
					@else
					<a href="{{ $data['produk-hukum']->attachment_fix }}" class="btn btn-primary btn-xs" target="_BLANK"><i class="icon-download"></i> DOWNLOAD / CETAK SK</a>
					@endif
                  
                    <h5>Keterangan</h5>
                    <ul>
                        @if ($data['produk-hukum']->fid_jenis_produk_hukum==3)
                            <li>di Cetak Rangkap 3</li>
                            <li>1 rangkap (tanpa materai) di paraf per lembar + lampiran (jika ada) oleh kepala OPD/pejabat yang mengajukan</li>
                            <li>1 rangkap diberi materai di PIHAK KESATU</li>
                            <li>1 rangkap diberi materai di PIHAK KEDUA</li>
                        @else
                            <li>di Cetak Rangkap 2</li>
                            <li>1 rangkap di paraf per lembar + lampiran (jika ada) oleh kepala OPD/pejabat yang mengajukan</li>
                        @endif
                        
                      @if ($data['produk-hukum']->fid_pejabat_penetap==1)
                      <li>disertai Nota Dinas</li>
                      <li>disertai Baju Surat</li>
                      @else
                      <li>disertai Nota Dinas</li>
                      @endif
                    </ul>
                  </td>
              	</tr>
              	<tr>
              		<td>Lampiran Produk Hukum</td>
              		<td>:</td>
              		<td>
              		@if (empty($data['produk-hukum']->lampiran_link) && empty($data['produk-hukum']->lampiran))
              		Lampiran tidak tersedia
              		@else
              		    
    					@if (!empty($data['produk-hukum']->lampiran_link))
    					<a href="{{ $data['produk-hukum']->lampiran_link }}" class="btn btn-primary btn-xs" target="_BLANK"><i class="icon-download"></i> DOWNLOAD / CETAK LAMPIRAN</a>
    					@endif
    					
    					@if (!empty($data['produk-hukum']->lampiran))
    					<a href="{{asset('storage/'.$data['produk-hukum']->lampiran)}}" class="btn btn-primary btn-xs" target="_BLANK"><i class="icon-download"></i> DOWNLOAD / CETAK LAMPIRAN</a>
    					@endif
					
					<h5>Keterangan</h5>
                    <ul>
                        <li>Pastikan bahwa lampiran yang akan dicetak sesuai dengan yang sudah disetujui</li>
                    </ul>
					
					@endif
                  
                    
                  </td>
              	</tr>
              	{{-- <tr>
              		<td>Status</td>
              		<td>:</td>
              		<td><span class="label" style="background:{{$data['produk-hukum']->label}}">{{$data['produk-hukum']->status_produk}}</label></td>
              	</tr> --}}
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
    
<!--######################################## tracking ####################################################-->
<!--############################# tracking di admin #################################-->
    <div class="col-md-4">
        <div class="panel-body" style="background:#e9e9e9">
            <h5 style="text-align:center;font-weight:bold">Tracking Produk Hukum</h5>
            
        @if(Session::get('useractive')->hak_akses==1)
            <form action="{{url('produk/tracking/proses')}}" method="POST">
                {{ csrf_field() }}
                <div class="input-group">
                <select name="jenis_tracking" id="jenis_tracking" class="form-control select2" style="padding:0px 0px">
        			@foreach ($master['jenis-tracking'] as $key => $value)
        			<option value="{{$value->id}}">{{$value->jenis_tracking}}</option>
        			@endforeach
        		</select>
        		<span class="input-group-append">
		        <input type="hidden" name="id_usulan" value="{{$id}}">
                <input type="hidden" name="action" value="add">
                
                <button type="submit" class="btn btn-warning">Tambah Tracking</button>
                </span>
                </div>
            </form>
            <br />
        <table class="table">
        <thead>
	    <tr>
		    <th>No</th>
		    <th>Posisi</th>
		    <th>Tanggal</th>
		    <th>Act</th>
	    </tr>
	    </thead>
	    <tbody>
            @foreach ($data['kendali-tracking'] as $key => $value)
                <tr>
        			<td>{{$key+1}}</td>
        			<td>{{$value->status}}</td>
        			<td>{{tgl_indo($value->tanggal)}}</td>
        			<td>
        			<a href="javasript:;" onclick="confirmDelete('{{$value->id}}')" class=""><i class="icon-trash"></i></a>
        				<form action="{{url('produk/tracking/proses')}}" method="POST" id="hapus{{$value->id}}">
        				{{ csrf_field() }}
        				<input type="hidden" name="action" value="delete">
        				<input type="hidden" name="id_tracking" value="{{$value->id}}">
        				<input type="hidden" name="id_usulan" value="{{$id}}">
        				</form>
        			</td>
        		</tr>
        	@endforeach
    	</tbody>
    	</table>
    	@else
<!--    ############################# tracking di menu selain admin ###################### -->
        <table class="table">
	    <thead>
	    <tr>
		    <th>No</th>
		    <th>Posisi</th>
		    <th>Tanggal</th>
	    </tr>
	    </thead>
	    <tbody>
        @foreach ($data['kendali-tracking'] as $key => $value)
                <tr>
        			<td>{{$key+1}}</td>
        			<td>{{$value->status}}</td>
        			<td>{{tgl_indo($value->tanggal)}}</td>
        		</tr>
    	@endforeach
    	</tbody>
    	</table>

        @endif
        </div>
    </div>
<!--###################################### end of tracking ############################################## -->    
    
  </div>
</div>
@endsection
@section('js')
<script>

</script>
@endsection
