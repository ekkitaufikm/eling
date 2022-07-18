@php($page='master')
@php($subpage='user')
@extends('layout.main')
@section('title')
  Data Informasi | ELING KOTA SEMARANG
@endsection
{{-- load page title --}}
@section('page-title')
    Master Informasi
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
  <li class="breadcrumb-item text-white opacity-75">Informasi</li>
  <!--end::Item-->
@endsection
{{-- end load page breadcrumb --}}
@section('css')

@endsection
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
          <button type="button" onclick="addInfo()" class="btn btn-bg-danger float-end text-white btn-active-color-primary">
              <i class="fa fa-plus-square text-white text-active-primary"></i>
              Tambah
          </button>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-row-bordered align-middle gy-5 gs-7" id="tabel_satker">
            <thead class="fw-bolder">
              <tr>
              	<th data-priority="1">No</th>
                <th>Judul</th>
                <th>Status</th>
                <th width="150px">Actions</th>
              </tr>
            </thead>
            <tbody id="main-bdy" class="fw-bold">
              @foreach ($data['info'] as $key => $value)
                @php
                    if($value->publish=="1"){
                      $set_status = '<button class="btn btn-success">Aktif</button>';
                    }else{
                      $set_status = '<button class="btn btn-danger">Tidak Aktif</button>';
                    }
                @endphp
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$value->judul_informasi}}</td>
                  <td>{!! $set_status !!}</td>
                  <td>
                    <button class="btn btn-warning btn-icon btn-ganti-status" data-id="{{ $value->id_informasi }}" data-nama="{{ $value->judul_informasi }}" data-status="{{ $value->publish }}" title="Ganti Status"><i class="fa fa-recycle"></i>
                    </button>
                    <a href="javascript:;" onclick="editInfo('{{ $value->id_informasi }}')" class="btn btn-primary btn-icon"><i class="fa fa-edit"></i></a>
                    <a href="javascript:;" onclick="confirmDelete('{{$value->id_informasi}}')"class="btn btn-danger btn-icon"><i class="fa fa-trash"></i></a>
                    <form action="{{url('master/info/proses/delete='.$value->id_informasi)}}" method="post" id="hapus{{$value->id_informasi}}">{{ csrf_field()}}</form>
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
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header bg-danger">
              <h5 class="modal-title text-white">Tambah Informasi</h5>

              <!--begin::Close-->
              <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                  <span class="fa fa-times text-white"></span>
              </div>
              <!--end::Close-->
          </div>
          <form class="form-horizontal" action="{{url('master/info/proses/simpan')}}" enctype="multipart/form-data" method="POST">
            {{ csrf_field() }}
            <div class="modal-body">
              <div class="form-group row mb-6">
                <label class="col-lg-3 col-form-label">Judul</label>
                <div class="col-lg-9">
                  <input type="text" class="form-control" name="judul_informasi" id="judul_informasi">
                </div>
              </div>
              <div class="form-group row mb-6">
                <label class="col-lg-3 col-form-label">Gambar Informasi <span>*JPG, PNG JPEG MAX : 5MB</span></label>
                <div class="col-lg-9">
                  <input type="file" class="form-control mb-2" onchange="preview(this)" name="file_informasi" id="file_informasi">
                  <img src="" id="frame" alt="" style="width: 30%">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" name="id_informasi" id="id_informasi">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-danger">Simpan</button>
            </div>
          </form>
      </div>
  </div>
</div>
{{-- end modal --}}
@endsection
@section('js')
<script>
function addInfo(){
  $('#judul_informasi').val('');
  $('#id_informasi').val(0);

  $('.modal-title').html('Tambah Informasi');
  $('#modalSatker').modal('show');
}
function editInfo(id){
  $.get("{{ url('api/info') }}/"+id,function(result){
    $('#judul_informasi').val(result.judul_informasi);
    $('#id_informasi').val(id);
    $("#frame").attr("src", result.file_informasi);

    $('.modal-title').html('Edit Informasi');
    $('#modalSatker').modal('show');
  });
}

function preview(input) {
  var file = $("input[type=file]").get(0).files[0];

  if(file){
    var reader = new FileReader();

    reader.onload = function(){
        $("#frame").attr("src", reader.result);
    }
    reader.readAsDataURL(file);
  }
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
        var set_status = "Tidak Aktif";
        var set_status_value = "0";
      } else {
        var set_status = "Aktif";
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
                    url: 		"{{ url('master/info/update_status') }}/" + kode,
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
