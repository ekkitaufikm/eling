@php
use Illuminate\Support\Facades\Session;
$user=Session::get('useractive');
@endphp
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/x-icon" href="{{asset('assets/images/fav.ico')}}"/>
	<title>@yield('title')</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="{{asset('assets/dropify-master/dist/css/dropify.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/sweetalert/sweetalert2.min.css')}}" />
	<link href="{{asset('assets/css/icons/icomoon/styles.css')}} " rel="stylesheet" type="text/css">
  <link href="{{asset('assets/css/icons/fontawesome/styles.min.css')}} " rel="stylesheet" type="text/css">
  <link href="{{asset('assets/css/bootstrap.css')}} " rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/core.css')}} " rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/components.css')}} " rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/colors.css')}} " rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<!--DataTables CSS -->
	<link href="{{asset('assets/datatables/plugins/datatables/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css">
	
	<style>
	/* .table>tbody>tr>td{
		padding:5px;
	} */
	.radio, .checkbox {
    margin-top: 0px;
    margin-bottom: 0px;
	}
	.bg-warning {
    background-color: #f6b242;
    border-color: #f6b242;
    color: #fff;
	}
	.bg-danger {
    background-color: #da251d;
    border-color: #da251d;
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
	.navbar-header {
    margin-left: 0px;
    margin-top: 5px;
    margin-bottom: 5px;
	}
	.table>thead>tr>th {
    border-bottom: 1px solid #bbb;
    background: whitesmoke;
	}
	</style>
  @yield('css')
</head>
<body>
		<!-- Main navbar -->
	<div class="navbar navbar-inverse" style="background:#da251d">
		<div class="navbar-header" >
			<a href="{{url('')}}"><img src="{{asset('assets/images/logo.png')}}" style="height:70px"></a>
			<ul class="nav navbar-nav pull-right visible-xs-block" >
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
			</ul>
		</div>
		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<img src="{{asset('assets/images/profil-photo.jpg')}}" alt="">
						<span>{{$user->nama}}</span>
						<i class="caret"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="#modalPassword"  data-toggle="modal"><i class="icon-lock2"></i> Ubah Password</a></li>
						<li><a href="#modalTahun"  data-toggle="modal"><i class=" icon-calendar2"></i> Ubah Tahun</a></li>
						<li><a href="{{url('logout')}}"><i class="icon-switch2"></i> Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<div class="navbar navbar-default" id="navbar-second">
		<ul class="nav navbar-nav no-border visible-xs-block">
			<li><a class="text-center collapsed" data-toggle="collapse" data-target="#navbar-second-toggle"><i class="icon-menu7"></i></a></li>
		</ul>
		<div class="navbar-collapse collapse" id="navbar-second-toggle">
			<ul class="nav navbar-nav">
				<li class="@if($page=='dashboard') active @endif" ><a href="{{url('dashboard')}}"><i class="icon-display4 position-left"></i> Dashboard</a></li>
				@if($user->hak_akses==1)
				<li class="@if($page=='master') active @endif dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-folder4 position-left"></i> Data Master <span class="caret"></span>
					</a>
					<ul class="dropdown-menu width-200">
						<li><a href="{{url('master/satker')}}"><i class="icon-arrow-right13"></i> Satuan Kerja</a></li>
						<li><a href="{{url('master/user')}}"><i class="icon-arrow-right13"></i> User Login</a></li>
						<li><a href="{{url('master/setting-status')}}"><i class="icon-arrow-right13"></i>Status Usulan Produk Hukum</a></li>
						<li><a href="{{url('master/setting-dashboard')}}"><i class="icon-arrow-right13"></i>Pengaturan Landing Page</a></li>
					</ul>
				</li>
				@endif
				@php($arr_akses=array('6,7,8,9'))
				@if(!in_array($user->hak_akses,$arr_akses))
				<li class="@if($page=='usulan') active @endif"><a href="{{url('usulan')}}"><i class="icon-file-text2 position-left"></i>Usulan Produk Hukum</a></li>
				@endif
				<li class="@if($page=='produk') active @endif"><a href="{{url('produk')}}"><i style="font-size:20px" class="icon-law position-left"></i> Produk Hukum</a></li>
				@if($user->hak_akses==1)
				<li class="@if($page=='usulan/hapus') active @endif"><a href="{{url('usulan/hapus')}}"><i style="font-size:20px" class="icon-reset position-left"></i> Usulan Dihapus</a></li>
				@endif
				<li class="@if($page=='laporan') active @endif"><a href="{{url('laporan')}}"><i style="font-size:20px" class="icon-printer2 position-left"></i> Laporan</a></li>
				<li class="@if($page=='notifikasi') active @endif"><a href="{{url('notifikasi')}}"><i style="font-size:20px" class="icon-bell3 position-left"></i>Notifikasi</a></li>
				<li class=""><a href="{{asset('assets/buku_panduan.pdf')}}" target='_blank'><i style="font-size:20px" class="icon-book position-left"></i>Buku Panduan</a></li>
			</ul>
		</div>
	</div>

	<div class="modal fade" id="modalPassword" tabindex="-1" role="dialog"  aria-hidden="true">
		<div class="modal-dialog ">
			<div class="modal-content">
				<form action="{{url('ubah-password/'.$user->id)}}" method="post">
					{{ csrf_field() }}
					<div class="modal-header bg-danger">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h6 class="modal-title" id="title">UBAH PASSWORD</h6>
					</div>
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
						<button type="submit" class="btn btn-warning">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalTahun" tabindex="-1" role="dialog"  aria-hidden="true">
		<div class="modal-dialog ">
			<div class="modal-content">
				<form action="{{url('ubah-tahun/')}}" method="post">
					{{ csrf_field() }}
					<div class="modal-header bg-danger">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h6 class="modal-title" id="title">UBAH TAHUN REGISTRASI</h6>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>TAHUN</label>
							@php
							if(date('m')=='12'){
								$yearoption=date('Y')+1;
							}
							else{
								$yearoption=date('Y');
							}
							@endphp
							<select class="select2" name="tahun">
								@for($year=2017;$year<=$yearoption;$year++)
								<option value="{{$year}}" @if(Session::get('yearactive')==$year) selected @endif>{{$year}}</option>
								@endfor
							</select>
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

	<div class="page-container">
		<div class="page-content">
			<div class="content-wrapper">
        @yield('content')
			</div>
		</div>
		<div class="navbar navbar-default navbar-sm navbar-fixed-bottom" style="background:#da251d">
			<ul class="nav navbar-nav no-border visible-xs-block">
				<li><a class="text-center collapsed" data-toggle="collapse" data-target="#navbar-second"><i class="icon-circle-up2"></i></a></li>
			</ul>
			<div class="navbar-collapse collapse" id="navbar-second">
				<div class="navbar-text">
					<a href="#" style="color:#fff"> &copy; 2020. ELING KOTA SEMARANG</a>
				</div>
			</div>
		</div>
  </div>

	<script type="text/javascript" src="{{asset('assets/js/plugins/loaders/pace.min.js')}} "></script>
	<script type="text/javascript" src="{{asset('assets/js/core/libraries/jquery.min.js')}} "></script>
	<script type="text/javascript" src="{{asset('assets/js/core/libraries/bootstrap.min.js')}} "></script>
	<script type="text/javascript" src="{{asset('assets/js/plugins/loaders/blockui.min.js')}} "></script>
	<script type="text/javascript" src="{{asset('assets/js/plugins/ui/nicescroll.min.js')}} "></script>
	<script type="text/javascript" src="{{asset('assets/js/plugins/ui/drilldown.js')}} "></script>

	<script type="text/javascript" src="{{asset('assets/js/plugins/forms/selects/select2.min.js')}} "></script>
	<script type="text/javascript" src="{{asset('assets/js/core/libraries/jquery_ui/datepicker.min.js')}} "></script>
	<script type="text/javascript" src="{{asset('assets/datepicker/js/bootstrap-datepicker.min.js')}}" ></script>
	<script type="text/javascript" src="{{asset('assets/js/plugins/uploaders/fileinput.min.js')}} "></script>
	<script type="text/javascript" src="{{asset('assets/js/pages/uploader_bootstrap.js')}} "></script>
	<script type="text/javascript" src="{{asset('assets/dropify-master/dist/js/dropify.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/sweetalert/sweetalert.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/jstree/jstree.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/highcharts/highcharts.js')}}"></script>
	<script type='text/javascript' src='{{asset('assets/tinymce/jquery.tinymce.min.js')}}'></script>
	<script type="text/javascript" src="{{asset('assets/tinymce/tinymce.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/plugins/pickers/color/spectrum.js')}}"></script>
	{{-- <script type="text/javascript" src="{{asset('assets/js/plugins/forms/styling/switchery.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/plugins/forms/styling/switch.min.js')}}"></script> --}}
	<script type="text/javascript" src="{{asset('assets/js/core/app.js')}}"></script>
	{{-- <script type="text/javascript" src="{{asset('assets/js/pages/form_checkboxes_radios.js')}}"></script> --}}
	<!-- Theme JS files -->
	
	<!--  DataTables  Script-->
	<script type="text/javascript" src="{{asset('assets/datatables/plugins/datatables/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/datatables/plugins/datatables/dataTables.bootstrap.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/datatables/pages/datatables.init.js')}}"></script>
	

  <script>
  $(function(){
		$(".colorpicker-basic").spectrum({
			showInput: true
		});
		$('.select2').select2();
		$('.datepicker').datepicker({
			autoclose: true,
			showOtherMonths: true,
			selectOtherMonths: true,
      format: "dd-mm-yyyy",
    });
		$(".datepicker-month").datepicker({
				autoclose: true,
				format: "mm-yyyy",
				startView: "months",
				minViewMode: "months"
			});
	 	$('.dropify').dropify({
 		 	messages: {
 				'default': 'Drag and drop a file here or click',
 				'replace': 'Drag and drop or click to replace',
 				'remove':  'Remove',
 				'error':   'Ooops, something wrong happended.'
 		 	}
	 	});
		$(".styled, .multiselect-container input").uniform({
      radioClass: 'choice',

    });

		tinymce.init({
		selector: '.tinymce',
		height: 200,
		menubar: false,
		plugins: [
			'nonbreaking advlist autolink lists link image charmap print preview anchor textcolor',
			'searchreplace visualblocks code fullscreen',
		],
		toolbar: 'bold italic underline  | alignleft aligncenter alignright alignjustify',
		content_css: [
			'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
			'{{asset('assets/css/surat-style.css')}}'
		],
		nonbreaking_force_tab: true
		});

		@if(\Illuminate\Support\Facades\Session::has('message'))
	    swal({
	      icon: '{{ \Illuminate\Support\Facades\Session::get('message_type') }}',
	      text: '{{ \Illuminate\Support\Facades\Session::get('message') }}',
	      button: false,
	      timer: 1500
	    });
    @endif
  });

	// konfirmasi logout
	function confirmLogout(){
    swal({
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
    swal({
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
    swal({
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
