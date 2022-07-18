@php($page='master')
@php($subpage='user')
@extends('layout.main')
@section('title')
  Data User | ELING KOTA SEMARANG
@endsection
{{-- load page title --}}
@section('page-title')
    Master User
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
  <li class="breadcrumb-item text-white opacity-75">User</li>
  <!--end::Item-->
@endsection
{{-- end load page breadcrumb --}}
@section('css')

@endsection

{{-- load page title --}}
@section('page-title')
    Master User
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
  <li class="breadcrumb-item text-white opacity-75">Users</li>
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
          <button type="button" onclick="addUser()" class="btn btn-bg-danger float-end text-white btn-active-color-primary">
              <i class="fa fa-plus-square text-white text-active-primary"></i>
              Tambah
          </button>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-row-bordered align-middle gy-5 gs-7" id="tabel_user">
            <thead class="fw-bolder">
              <tr>
                <th data-priority="1" width="50px">No</th>
                <th>Nama Lengkap</th>
                <th>Username</th>
                <th>Satuan Kerja</th>
                <th>Hak Akses</th>
                <th width="150px">Actions</th>
              </tr>
            </thead>
            <tbody id="main-bdy" class="fw-bold">
              @foreach ($data['user'] as $key => $value)
              <tr>
                <td>{{ $key +1}}</td>
                <td>{{$value->nama}}</td>
                <td>{{$value->username}}</td>
                <td>{{$value->satker}}</td>
                <td>{{$value->hak_akses}}</td>
                <td>
                  <a href="javascript:;" onclick="editUser({{$value->id}})" class="btn btn-primary btn-icon"><i class="fa fa-edit"></i></a>
                  <a href="javascript:;" onclick="confirmDelete('{{$value->id}}')"class="btn btn-danger btn-icon"><i class="fa fa-trash"></i></a>
                  <form action="{{url('master/user/proses/delete='.$value->id)}}" method="post" id="hapus{{$value->id}}">{{ csrf_field()}}</form>
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
<div class="modal fade" tabindex="-1" id="modalUser">
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
          <form class="form-horizontal" action="{{url('master/user/proses')}}" method="POST">
            {{ csrf_field() }}
            <div class="modal-body">
              <div class="form-group row mb-6">
                <label class="col-lg-3 col-form-label"> Nama Lengkap </label>
                <div class="col-lg-9">
                  <input type="text" class="form-control" name="nama_lengkap" id="modal_nama">
                </div>
              </div>
              <div class="form-group row mb-6">
                <label class="col-lg-3 col-form-label"> Username </label>
                <div class="col-lg-9">
                  <input type="text" class="form-control" name="username" id="modal_username">
                </div>
              </div>
              <div class="form-group row mb-6">
                <label class="col-lg-3 col-form-label"> Password </label>
                <div class="col-lg-9">
                  <input type="text" class="form-control" id="modal_password" name="password">
                  <div style="color:#b50000;font-size:12px;font-style:italic" id="note" >Kosongi jika password tidak berubah</div>
                </div>
              </div>
              <div class="form-group row mb-6">
                <label class="col-lg-3 col-form-label"> Email </label>
                <div class="col-lg-9">
                  <input type="text" class="form-control" name="email" id="modal_email">
                </div>
              </div>
              <div class="form-group row mb-6">
                <label class="col-lg-3 col-form-label"> Nomor HP </label>
                <div class="col-lg-9">
                  <input type="text" class="form-control" name="hp" id="modal_hp">
                </div>
              </div>
              <div class="form-group row mb-6">
                <label class="col-lg-3 col-form-label"> Hak Akses </label>
                <div class="col-lg-9">
                  <select name="hak_akses" class="form-select" data-control="select2" id="modal_hakakses">
                    @foreach ($master['hak_akses'] as $key => $value)
                      <option value="{{$value->id}}" >{{$value->hak_akses}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group row mb-6">
                <label class="col-lg-3 col-form-label"> Satuan Kerja</label>
                <div class="col-lg-9">
                  <select name="satker" class="form-select" data-control="select2" id="modal_satker">
                    @foreach ($master['satker'] as $key => $value)
                      <option value="{{$value->id}}">{{$value->nama}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" name="id" id="id_user" >
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
$('#note').hide();
function addUser(){
  $('#modal_nama').val('');
  $('#modal_username').val('');
  $('#modal_email').val('');
  $('#modal_hp').val('');
  $('#id_user').val(0);

  $('#note').hide();
  $('#title_text').html('TAMBAH USER');
  $('#modalUser').modal('show');
}

function editUser(id){
  $.get("{{ url('api/user') }}/"+id,function(result){
    $('#modal_nama').val(result.nama);
    $('#modal_username').val(result.username);
    $('#modal_email').val(result.email);
    $('#modal_hp').val(result.phone);
    $('#id_user').val(id);

    $('#modal_satker').val(result.fid_satker);
    $('#modal_satker').select2();

    $('#modal_hakakses').val(result.hak_akses);
    $('#modal_hakakses').select2();
    $('#note').show();
    $('#title_text').html('EDIT USER');
    $('#modalUser').modal('show');
  });
}

$(document).ready(function() {
  var table = $('#tabel_user').DataTable({
    responsive: true
  });
  $('#smt-search').on( 'keyup', function () {
      table.search( this.value ).draw();
  });
});
</script>
@endsection
