@php($page='master')
@php($subpage='user')
@extends('layout.main')
@section('title')
  Data Kinerja | ELING KOTA SEMARANG
@endsection
@section('css')
<style>
.ui-datepicker {
  z-index: 10000 !important;
}
</style>
@endsection
@section('content')
<div class="page-header page-header-xs panel border-top-warning" style="padding-bottom: 0;">
	<div class="page-header-content">
		<div class="page-title">
			<h5><i class="icon-rocket position-left"></i> <span class="text-semibold">KINERJA BAGIAN HUKUM</span></h5>
      {{-- <input type="text" class="form-control datepicker-month" name="bulan" id="modal_bulan"> --}}
		</div>
	</div>
	<div class="breadcrumb-line breadcrumb-line-wide bg-danger" style="box-shadow: none; ">
		<ul class="breadcrumb">
			<li><a href="index.php"><i class="icon-home2 position-left"></i> Home</a></li>
			<li><a href="#">Master</a></li>
			<li class="active">Kinerja Bagian Hukum</li>
		</ul>
    <ul class="breadcrumb-elements">
			<li><a href="#modalKinerja"  data-toggle="modal"><i class="icon-file-plus position-left"></i>Tambah</a></li>
		</ul>
	</div>
  <div class="modal fade" id="modalKinerja" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h6 class="modal-title" id="title">TAMBAH KINERJA</h6>
        </div>
        <div class="view-body">
          <form class="form-horizontal" action="{{url('master/kinerja/proses')}}" method="POST">
            {{ csrf_field() }}
            <div class="modal-body">
              <div class="form-group">
                <label class="col-lg-3 control-label">Bulan</label>
                <div class="col-lg-9">
                  <input type="text" autocomplete="off" class="form-control datepicker-month" name="bulan" id="modal_bulan">
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-3 control-label">Jenis Produk Hukum</label>
                <div class="col-lg-9">
                  <select name="jenis" class="select2" id="modal_jenis">
                    @foreach ($master['jenis-produk-hukum'] as $key => $value)
                      <option value="{{$value->id}}" >{{$value->jenis_produk_hukum}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-3 control-label">Jumlah</label>
                <div class="col-lg-9">
                  <input type="text" class="form-control" name="jumlah" id="modal_jumlah">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" name="id" id="modal_id" value="0">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-warning">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <table class="table datatable-basic">
  	<thead>
  		<tr>
  			<th width="50px">No</th>
  			<th>Bulan</th>
  			<th>Jenis Produk Hukum</th>
        <th>Nilai</th>
  			<th width="150px">Actions</th>
  		</tr>
  	</thead>
  	<tbody>
      @foreach ($data['data'] as $key => $value)
        <tr>
    			<td>{{(($data['pageposition']-1)*10)+($key+1)}}</td>
    			<td>{{$value->bulan}}</td>
        	<td>{{$value->jenis_produk_hukum}}</td>
          <td>{{$value->jumlah}}</td>
    			<td>
    				<a href="javascript:;" onclick="editKinerja('{{$value->id}}')"  class="btn btn-primary btn-xs"><i class="icon-pen2"></i></a>
    				<a href="javascript:;" onclick="confirmDelete('{{$value->id}}')" class="btn btn-danger btn-xs"><i class="icon-bin"></i></a>
            <form action="{{url('master/kinerja/proses/delete='.$value->id)}}" method="post" id="hapus{{$value->id}}">{{ csrf_field()}}</form>
    			</td>
    		</tr>
      @endforeach
    </tbody>
  </table>
  <div class="page-footer-content">
    @php($pageurl = url('master/kinerja'))
    @include('include.pagination')
	</div>
</div>

@endsection
@section('js')
<script>
$('#note').hide();
function editKinerja(id){
  $.get("{{ url('api/kinerja') }}/"+id,function(result){
    $('#modal_bulan').val(result.bulan);
    $('#modal_jumlah').val(result.jumlah);
    $('#modal_id').val(id);

    $('#modal_jenis').val(result.fid_jenis_produk_hukum);
    $('#modal_jenis').select2();

    $('#title').html('EDIT KINERJA');
    $('#modalKinerja').modal('show');
  });
}
</script>
@endsection
