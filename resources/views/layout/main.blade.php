 {{-- config session --}}
 @php
 use Illuminate\Support\Facades\Session;
 $user=Session::get('useractive');
 @endphp
 {{-- end config session --}}
 
<!DOCTYPE html>
<html lang="en">
<head>
    {{-- include metadata --}}
    @include('include.metadata')
    {{-- end include metadata --}}
    @yield('css')
</head>
<body id="kt_body" style="background-image: url({{ asset('assets/images/bg-login.png') }})" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">
  <div class="d-flex flex-column flex-root">
    <div class="page d-flex flex-row flex-column-fluid">
      <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
        {{-- include header --}}
        @include('include.header')
        {{-- end include header --}}
        <div class="toolbar py-5 py-lg-15" id="kt_toolbar">
            <!--begin::Container-->
            <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column me-3">
                    <h1 class="d-flex text-white fw-bolder my-1 fs-3">@yield('page-title')</h1>
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        @yield('page-breadcrumb')
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Container-->
        </div>
        <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
          <div class="content flex-row-fluid" id="kt_content">
            <div class="row g-5 g-xl-8">
              @yield('content')
            </div>
          </div>
        </div>
        {{-- include footer --}}
        @include('include.footer')
        {{-- end include footer --}}
      </div>
    </div>
  </div>
  <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
    <span class="svg-icon">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
        <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor"></rect>
        <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor"></path>
      </svg>
    </span>
    <!--end::Svg Icon-->
  </div>

  {{-- modal lupa password dan ubah tahun --}}
    <div class="modal fade" id="modalPassword" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header bg-danger" id="title">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold" style="color:#FFFF">Ubah Password</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close"></div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <div class="view-body">
                    <form action="{{url('ubah-password/'.$user->id)}}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Password Lama</label>
                                <input type="password" name="pass_lama" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Password Baru</label>
                                <input type="password" name="pass_baru" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Ulangi Password Baru</label>
                                <input type="password" name="re_pass_baru" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id" id="modal_id" value="0">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-danger">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTahun" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header bg-danger" id="title">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold" style="color:#FFFF">Ubah Tahun</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close"></div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <div class="view-body">
                    <form action="{{url('ubah-tahun/')}}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-lg-3 control-label">TAHUN</label>
                                <div class="col-lg-12">
                                    @php
                                    if(date('m')=='12'){
                                        $yearoption=date('Y')+1;
                                    }
                                    else{
                                        $yearoption=date('Y');
                                    }
                                    @endphp
                                    <select name="tahun" class="form-select form-select-solid fw-bold" data-kt-select2="true" data-placeholder="Select Tahun" data-allow-clear="true" data-hide-search="true">
                                        <option></option>
                                        @for($year=2017;$year<=$yearoption;$year++)
                                            <option value="{{$year}}" @if(Session::get('yearactive')==$year) selected @endif>{{$year}}</option>
                                        @endfor
                                    </select>
                                </div>
                              </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id" id="modal_id" value="0">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-danger">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  {{-- end modal lupa password dan ubah tahun --}}
  <script>
    // konfirmasi logout
	function confirmLogout(){
    swal.fire({
      title: "Are you sure?",
      text: "Apakah anda yakin ingin keluar ini",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
          $('#logout').submit();
      } else {

      }
    });
  }

  // Konfirmasi Hapus
  function confirmDelete(id){
    swal.fire({
      title: "Are you sure?",
      text: "Apakah anda yakin ingin menghapus data ini",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
          $('#hapus'+id).submit();
      } else {

      }
    });
  }
  
  //update status
  function confirmUpdate(id){
    swal.fire({
      title: "Are you sure?",
      text: "Apakah anda yakin ingin mengembalikan data ini",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
          $('#update_status'+id).submit();
      } else {

      }
    });
  }
  </script>
  @yield('js')
</body>
</html>