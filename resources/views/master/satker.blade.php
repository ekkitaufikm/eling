@php($page='master')
@php($subpage='user')

@extends('layout.main')
@section('title')
  Data Satker | ELING KOTA SEMARANG
@endsection
{{-- load page title --}}
@section('page-title')
    Master Satuan Kerja
@endsection
{{-- end load page title --}}

{{-- load page breadcrumb --}}
@section('page-breadcrumb')
  <!--begin::Item-->
  <li class="breadcrumb-item text-white opacity-75">
      <a href="#" class="text-white text-hover-primary">Data Master</a>
  </li>
  <!--end::Item-->
  <!--begin::Item-->
  <li class="breadcrumb-item">
      <span class="bullet bg-white opacity-75 w-5px h-2px"></span>
  </li>
  <!--end::Item-->
  <!--begin::Item-->
  <li class="breadcrumb-item text-white opacity-75">Satuan Kerja</li>
  <!--end::Item-->
@endsection
{{-- end load page breadcrumb --}}
@section('css')

@endsection

{{-- load page title --}}
@section('page-title')
    Master Satker
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
  <li class="breadcrumb-item text-white opacity-75">Master</li>
  <!--end::Item-->
  <!--begin::Item-->
  <li class="breadcrumb-item">
    <span class="bullet bg-white opacity-75 w-5px h-2px"></span>
  </li>
  <!--end::Item-->
  <!--begin::Item-->
  <li class="breadcrumb-item text-white opacity-75">Satker</li>
  <!--end::Item-->
@endsection
{{-- end load page breadcrumb --}}

@section('content')
<div class="col-xl-12">
  <div class="card card-xl-stretch">
    <div class="card-body">
      <div class="row mb-10">
        <div class="col-md-6">
          {{-- inclued search table --}}
            @include('include.search_table')
          {{-- end include search table --}}
        </div>
        <div class="col-md-6">
          <button type="button" onclick="addSatker()" class="btn btn-bg-danger float-end text-white btn-active-color-primary">
              <i class="fa fa-plus-square text-white text-active-primary"></i>
              Tambah
          </button>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-row-bordered align-middle gy-5 gs-7" id="tabel_satker">
            <thead class="fw-bolder">
              <tr>
              	<th data-priority="1">Nomor Urut</th>
                <th>Satuan Kerja</th>
                <th>Parent</th>
                <th>Status</th>
                <th width="150px">Actions</th>
              </tr>
            </thead>
            <tbody id="main-bdy" class="fw-bold">
              @foreach ($data['satker'] as $key => $value)
                @php
                    if($value->publish=="1"){
                      $set_status = "Terdaftar";
                    }else{
                      $set_status = "Tidak Terdaftar";
                    }
                @endphp
                <tr>
                  <td>{{$value->kode_satker}}</td>
                  <td>{{$value->nama}}</td>
                  <td>@if(!empty($value->nama_parent)){{$value->nama_parent}}@else Tidak Mempunyai Parent @endif</td>
                  <td>{{ $set_status }}</td>
                  <td>
                    <button class="btn btn-warning btn-icon btn-ganti-status" data-id="{{ $value->id }}" data-nama="{{ $value->nama }}" data-status="{{ $value->publish }}" title="Ganti Status"><i class="fa fa-recycle"></i>
                    </button>
                    <a href="javascript:;" onclick="editSatker('{{$value->id}}')" class="btn btn-primary btn-icon"><i class="fa fa-edit"></i></a>
                    <a href="javascript:;" onclick="confirmDelete('{{$value->id}}')"class="btn btn-danger btn-icon"><i class="fa fa-trash"></i></a>
                    <form action="{{url('master/satker/proses/delete='.$value->id)}}" method="post" id="hapus{{$value->id}}">{{ csrf_field()}}</form>
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
{{-- modal --}}
<div class="modal fade" tabindex="-1" id="modalSatker">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header bg-danger">
              <h5 class="modal-title text-white">Tambah Satuan Kerja</h5>

              <!--begin::Close-->
              <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                  <span class="fa fa-times text-white"></span>
              </div>
              <!--end::Close-->
          </div>
          <form class="form-horizontal" action="{{url('master/satker/proses')}}" method="POST">
            {{ csrf_field() }}
            <div class="modal-body">
              <div class="form-group row mb-6">
                <label class="col-lg-3 col-form-label">Nomor Urut Satker</label>
                <div class="col-lg-9">
                  <input type="text" class="form-control" name="kode" id="modal_kode">
                </div>
              </div>
              <div class="form-group row mb-6">
                <label class="col-lg-3 col-form-label">Nama Satker</label>
                <div class="col-lg-9">
                  <input type="text" class="form-control" name="nama" id="modal_nama">
                </div>
              </div>
              <div class="form-group row mb-6">
                <label class="col-lg-3 col-form-label">Satker Parent</label>
                <div class="col-lg-9">
                  <select name="parent" class="form-select" data-control="select2" id="modal_satker">
                    <option value="0" >Tidak Mempunyai Parent</option>
                    @foreach ($master['satker'] as $key => $value)
                      <option value="{{$value->id}}" >{{$value->nama}}</option>
                    @endforeach
                  </select>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <input type="hidden" name="id" id="id_satker">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-danger">Simpan</button>
            </div>
          </form>
      </div>
  </div>
{{-- end modal --}}
@endsection
@section('js')
<script>
function addSatker(){
  $('#modal_nama').val('');
  $('#modal_kode').val('');
  $('#id_satker').val(0);

  $('#title_satker').html('TAMBAH SATKER');
  $('#modalSatker').modal('show');
}
function editSatker(id){
  $.get("{{ url('api/satker') }}/"+id,function(result){
    $('#modal_nama').val(result.nama);
    $('#modal_kode').val(result.kode_satker);
    $('#id_satker').val(id);

    $('#modal_satker').val(result.parent_id);
    $('#modal_satker').select2();

    $('#title_satker').html('EDIT SATKER');
    $('#modalSatker').modal('show');
  });
}

$(document).ready(function() {
  var table = $('#tabel_satker').DataTable({
    responsive: true
  });
  $('#smt-search').on( 'keyup', function () {
        table.search( this.value ).draw();
    });
  $('#main-bdy').on('click','.btn-ganti-status',function () {
      var kode 	= $(this).data('id');
      var nama 	= $(this).data('nama');
      var status = $(this).data('status');
      if (status=="1") {
        var set_status = "Tidak Terdaftar";
        var set_status_value = "0";
      } else {
        var set_status = "Terdaftar";
        var set_status_value = "1";
      }
      swal.fire({
            title: "Apakah anda yakin?",
            text: "Untuk merubah data : " + nama + " menjadi "+set_status,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 		'ajax',
                    method: 	'get',
                    url: 		"{{ url('master/satker/update_status') }}/" + kode+"/"+set_status_value,
                    async: 		true,
                    dataType: 	'json',
                    success: 	function(response){
                        if(response.status==true){
                            swal.fire({title: "Success!", text: "Berhasil Mengubah Data", icon: "success"})
                                .then(function(){ 
                                location.reload(true);
                            });
                        }else{
                            swal.fire("Mengubah Data Gagal !", {
                                icon: "warning",
                            });
                        }
                    },
                    error: function(){
                        swal.fire("ERROR", "Mengubah Data Gagal.", "error");
                    }
                });
            } else {
                swal.fire("Cancelled", "Mengubah Data Dibatalkan.", "error");
            }
        });	
  })
});

</script>
@endsection
