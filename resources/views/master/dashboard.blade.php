@php($page='master')
@php($subpage='status')
@extends('layout.main')
@section('title')
  Setting Landing Page | ELING KOTA SEMARANG
@endsection
{{-- load page title --}}
@section('page-title')
    Pengaturan Landing Page
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
  <li class="breadcrumb-item text-white opacity-75">Pengaturan Landing Page</li>
  <!--end::Item-->
@endsection
{{-- end load page breadcrumb --}}
@section('css')
<style>
/* .radio, .checkbox {
  margin-top: 0px;
  margin-bottom: 0px;
}
.bg-warning {
  background-color: #d04e00;
  border-color: #d04e00;
  color: #fff;
}
.label {
  display: inline-block;
  font-weight: 300;
  padding: 1px 4px 0 4px;
  line-height: 1.5384616;
  border: 1px solid transparent;
  text-transform: uppercase;
  font-size: 12px;
  letter-spacing: 1px;
  border-radius: 0px;
}
.navbar-default .navbar-nav>.active>a {
  -webkit-box-shadow: 0 1px 0 0 #26a69a;
  box-shadow: 0 1px 0 0 #df6048;
}
.page-footer-content{
  padding:30px;
  border-top:1px solid #dddddd
}
.search-header{
  padding:30px;
  border-bottom:1px solid #bbbbbb
}
.input-group {
  position: relative;
  display: -ms-flexbox;
  display: flex;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;
  -ms-flex-align: stretch;
  align-items: stretch;
  width: 100%;
}
.input-group>.custom-file,
.input-group>.custom-select,
.input-group>.form-control {
  position: relative;
  -ms-flex: 1 1 auto;
  flex: 1 1 auto;
  width: 1%;
  margin-bottom: 0;
}
.input-group-addon{
  width:auto
}
.input-group-append, .input-group-prepend {
  display: -ms-flexbox;
  display: flex;
}
.input-group-append {
  margin-left: -1px;
}
.btn-light {
  color: #333;
  background-color: #fafafa;
  border-color: #ddd;
}
.perihal, .satker{
  font-weight: bold;
  font-size: 15px
}
.nomor, .tanggal, .jenis{
  font-size: 12px
}
.table tbody tr td{
  vertical-align: top
}
.pagination>.active>a,
.pagination>.active>span,
.pagination>.active>a:hover,
.pagination>.active>span:hover,
.pagination>.active>a:focus,
.pagination>.active>span:focus {
  z-index: 2;
  color: #fff;
  background-color: #df6048;
  border-color: #df6048;
  cursor: default;
}
.page-widget{
  padding:50px 80px
}
.navbar-default.navbar-fixed-bottom {
  border-top-color: #d04f2e;
  border-bottom-color: transparent;
} */
</style>
@endsection
@section('content')
<div class="col-xl-12">
  <div class="card card-xl-stretch">
    <div class="card-body">
      <div class="row mb-10">
        {{-- slide show --}}
        <div class="col-md-12">
    
          <div id="kt_carousel_1_carousel" class="carousel carousel-custom slide" data-bs-ride="carousel" data-bs-interval="8000">
            <!--begin::Heading-->
            <div class="d-flex align-items-center justify-content-between flex-wrap">
                <!--begin::Label-->
                {{-- <span class="fs-4 fw-bolder pe-2">Title</span> --}}
                <!--end::Label-->

                <!--begin::Carousel Indicators-->
                <ol class="p-0 m-0 carousel-indicators carousel-indicators-dots">
                  @php
                      $no = 0;
                  @endphp
                  @foreach ($data['slider'] as $item)
                  @php
                      if ($no < 1) {
                        $class_indikator_slider = "active";
                      }else{
                        $class_indikator_slider = null;
                      }
                  @endphp
                    <li data-bs-target="#kt_carousel_1_carousel" data-bs-slide-to="{{ $no }}" class="ms-{{ $no }} {{ $class_indikator_slider }}"></li>
                  @php
                      $no++;
                  @endphp
                  @endforeach
                </ol>
                <!--end::Carousel Indicators-->
            </div>
            <!--end::Heading-->

            <!--begin::Carousel-->
            <div class="carousel-inner pt-8">
              @php
                $no = 0;
              @endphp
              @foreach ($data['slider'] as $item)
              @php
                  if ($no < 1) {
                    $class_slider = "active";
                  }else{
                    $class_slider = null;
                  }
              @endphp
              <!--begin::Item-->
              <div class="carousel-item {{ $class_slider }}">
                <img src="{{asset('storage/'.$item->slider)}}" width="100%" class="mb-10 mt-10">
              </div>
              <!--end::Item-->
              @php
                 $no++;
              @endphp
              @endforeach
            </div>
            <!--end::Carousel-->
          </div>
             
        </div>
        {{-- end slide show --}}
        {{-- tentang --}}
        <div class="col-md-12">
          <div style="background:#393939;" class="page-widget">
            <div class="row">
              <div class="col-md-5 mt-11 mb-11">
                <img src="{{url('storage/'.$data['single-post'][3]->content)}}" style="width:100%;margin-left:10%">
                <form action="{{url('master/save-dashboard')}}" method="post" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  <input type="file" class="form-control mt-5" name="content" style="margin-left:10%" onchange="javascript:submit()">
                  <input type="hidden" name="id" value="3">
                </form>
              </div>
              <div class="col-md-7 mt-11 mb-11">
                <h3 style="color:#ffffff;font-size:35px;margin-top:0px;margin-left:10%">Tentang <span style="font-weight:bold;color:#ff9029">eLING</span></h3>
                <form action="{{url('master/save-dashboard')}}" method="post">
                  {{ csrf_field() }}
                  <div class="form-group" style="margin-left:10%;margin-right:10%;">
                    <textarea class="tinymce" name="content">{!!$data['single-post'][1]->content!!}</textarea>
                  </div>
                  <input type="hidden" name="id" value="1">
                  <button style="margin-left:10%;" class="btn mt-5 btn-block btn-warning">SIMPAN</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        {{-- end tentang --}}
        <div class="col-md-12">
          <div style="background:#ededed;" class="page-widget">
            <div class="row">
              <div class="col-md-5 mt-15 mb-11">
                <h3 style="color:#000;font-size:35px;margin-left:10%">Cara Kerja <span style="font-weight:bold;color:#9a3300">eLING</span></h3>
                <form action="{{url('master/save-dashboard')}}" method="post">
                  {{ csrf_field() }}
                  <div class="form-group" style="margin-left:10%;">
                    <textarea class="tinymce" name="content">{!!$data['single-post'][2]->content!!}</textarea>
                  </div>
                  <input type="hidden" name="id" value="2">
                  <button style="margin-left:10%;" class="btn mt-5 btn-block btn-warning">SIMPAN</button>
                </form>
              </div>
              <div class="col-md-7 mt-11 mb-11">
                <img src="{{url('storage/'.$data['single-post'][4]->content)}}" style="width:100%">
                <form action="{{url('master/save-dashboard')}}" method="post" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  <input type="file" class="form-control w-475px" style="margin-left: 10%;" name="content" onchange="javascript:submit()">
                  {{-- <div class="uploader" style="margin-top:10px">
                    
                    <span class="filename" style="user-select: none;">Upload Gambar Cara Kerja eLING</span>
                    <span class="action" style="user-select: none;"><i class="icon-plus2"></i></span>
                  </div> --}}
                  <input type="hidden" name="id" value="4">
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<script src="{{asset('vendors/plugins/custom/tinymce/tinymce.bundle.js')}}"></script>
<script>
  var options = {selector: ".tinymce"};
  tinymce.init(options);
</script>
@endsection
