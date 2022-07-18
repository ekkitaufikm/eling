@php($page='master')
@php($subpage='status')
@extends('layout.main')
@section('title')
  Setting Status | ELING KOTA SEMARANG
@endsection
{{-- load page title --}}
@section('page-title')
    Master Setting Status
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
  <li class="breadcrumb-item text-white opacity-75">Setting Status</li>
  <!--end::Item-->
@endsection
{{-- end load page breadcrumb --}}
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.4.0/css/bootstrap-colorpicker.css" integrity="sha512-HcfKB3Y0Dvf+k1XOwAD6d0LXRFpCnwsapllBQIvvLtO2KMTa0nI5MtuTv3DuawpsiA0ztTeu690DnMux/SuXJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

{{-- load page title --}}
@section('page-title')
    Setting Status
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
  <li class="breadcrumb-item text-white opacity-75">Setting Status</li>
  <!--end::Item-->
@endsection
{{-- end load page breadcrumb --}}

@section('content')
<div class="col-xl-12">
  <div class="card card-xl-stretch">
    <div class="card-body">
      <div class="row mb-10">
        <div class="table-responsive">
          <table class="table table-striped table-row-bordered align-middle gy-5 gs-7" id="tabel_user">
            <thead class="fw-bolder">
              <tr>
                <th data-priority="1" width="5px">Id</th>
                <th>Status Produk</th>
                <th>Kode Warna</th>
                <th>Pilih Warna</th>
              </tr>
            </thead>
            <form action="{{url('master/setting-status/proses/produk')}}" method="post">
              {{ csrf_field() }}
              <tbody id="main-bdy" class="fw-bold">
                @foreach ($data['produk'] as $key => $value)
                  <tr>
                    <td>{{$key+1}}</td>
                    <td>
                      <input type="hidden" name="id[]" value="{{$value->id}}">
                      <input type="text" class="form-control" name="status[{{$value->id}}]" value="{{$value->status_produk}}">
                    </td>
                    <td style="width:100px;white-space:nowrap;">
                      <input type="text" name="label[{{$value->id}}]" class="form-control label-color" value="{{$value->label}}">
                    </td>
                    <td style="width:100px;white-space:nowrap;">
                      <div class="d-flex flex-row flex-column-fluid">
                        <div class="d-flex flex-row-fluid flex-center" style="background-color:{{$value->label}}" id="color-bg">
                            <span class="text-white">&nbsp;</span>
                        </div>
                      </div>
                      {{-- <input type="text" name="label[{{$value->id}}]" class="form-control colorpicker-basic" data-preferred-format="hex3" data-cancel-text="Cancel" data-choose-text="Pilih Warna" value="{{$value->label}}"> --}}
                    </td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="4">
                    <button type="submit" style="width: 100%;" class="btn btn-danger">SIMPAN</button>
                  </td>
                </tr>
              </tfoot>
            </form>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- <div class="page-header page-header-xs panel border-top-warning" style="padding-bottom: 0;">
	<div class="page-header-content">
		<div class="page-title">
			<h5><i class="icon-users2 position-left"></i> <span class="text-semibold">SETTING STATUS</span></h5>
		</div>
	</div>
	<div class="breadcrumb-line breadcrumb-line-wide bg-danger" style="box-shadow: none; ">
		<ul class="breadcrumb">
			<li><a href="index.php"><i class="icon-home2 position-left"></i> Home</a></li>
			<li><a href="#">Master</a></li>
			<li class="active">Setting Status</li>
		</ul>
	</div>
  <form action="{{url('master/setting-status/proses/produk')}}" method="post">
    {{ csrf_field() }}
    <table class="table datatable-basic">
      <thead>
        <tr>
          <th width="50px">Id</th>
          <th>Status Produk</th>
          <th>Kode Warna</th>
          <th>Pilih Warna</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data['produk'] as $key => $value)
          <tr>
            <th width="50px">Id</th>
            <th>Status Produk</th>
            <th>Kode Warna</th>
            <th>Pilih Warna</th>
          </tr>
        @endforeach
      </tbody>
    </table>
    <button type="submit" class="btn btn-warning btn-block">SIMPAN</button>
  </form>
</div> --}}
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.4.0/js/bootstrap-colorpicker.min.js" integrity="sha512-94dgCw8xWrVcgkmOc2fwKjO4dqy/X3q7IjFru6MHJKeaAzCvhkVtOS6S+co+RbcZvvPBngLzuVMApmxkuWZGwQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  $(function () {
    // Basic instantiation:
    $('.label-color').colorpicker();
      
      // Example using an event, to change the color of the #demo div background:
      $('#main-bdy').on('colorpickerChange','.label-color', function(event) {
        // console.log(event.color.toHexString());
        $(this).parent().parent().find('#color-bg').css("background-color", event.color.toHexString());
      });
  })
</script>
@endsection
