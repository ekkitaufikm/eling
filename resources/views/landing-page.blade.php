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
	<title>eLing Kota Semarang | Pemerintah Kota Semarang</title>
	<link rel="icon" type="image/png" href="{{asset('assets/images/fav.ico')}}">

	<!--begin::Fonts-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	<!--end::Fonts-->
	{{--  Css Wajib  --}}
	<link rel="stylesheet" href="{{asset('vendors/plugins/global/plugins.bundle.css')}}">
	<link rel="stylesheet" href="{{asset('vendors/css/style.bundle.css')}}">
	<link rel="stylesheet" href="{{asset('vendors/plugins/custom/datatables/datatables.bundle.css')}}">

	{{--  JS Wajib  --}}
	<script src="{{asset('vendors/plugins/global/plugins.bundle.js')}}"></script>
	<script src="{{asset('vendors/js/scripts.bundle.js')}}"></script>
	<script src="{{asset('vendors/js/jquery.form.js')}}"></script>
	<script src="{{asset('vendors/js/custom/documentation/search.js')}}"></script>
	<script src="{{asset('vendors/plugins/custom/datatables/datatables.bundle.js')}}"></script>

	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="{{asset('assets/dropify-master/dist/css/dropify.css')}}" />
	<link href="{{asset('assets/jstree/themes/default/style.min.css')}}" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="{{asset('assets/sweetalert/sweetalert2.min.css')}}" />
	<link href="{{asset('assets/css/icons/icomoon/styles.css')}} " rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/icons/fontawesome/styles.min.css')}} " rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/bootstrap.css')}} " rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/core.css')}} " rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/components.css')}} " rel="stylesheet" type="text/css">
	<link href="{{asset('assets/css/colors.css')}} " rel="stylesheet" type="text/css">
	
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
    border-top-color: #f6b243;
    border-bottom-color: transparent;
	}
	.navbar-header {
    margin-left: 0px;
    margin-top: 5px;
    margin-bottom: 5px;
	}
	</style>
  @yield('css')
</head>
	<body>
		<!-- Main navbar -->
		<div class="header align-items-stretch" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}" style="background:#da251d">
			<div class="header-logo me-5 me-md-10 flex-grow-1 flex-lg-grow-0" >
				<img src="{{asset('assets/images/logo.png')}}" style="width:130px; margin-left:30px">
				<ul class="nav navbar-nav pull-right visible-xs-block" >
					<li><a data-toggle="collapse" data-target="#navbar-mobile" class="" aria-expanded="true"><i class="icon-tree5"></i></a></li>
				</ul>
			</div>

			<div class="navbar-collapse collapse" data-toggle="collapse" id="navbar-mobile">
				<ul class="nav navbar-nav navbar-text navbar-right">
					@if(!empty($user))
					<div class="dropdown" >
						<a class="btn me-2 dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius:30px; background:#8C0C06; color:#fff">
							<div class="symbol symbol-30px me-5">
								<img alt="Logo" src="{{ asset('assets/images/profil-photo.jpg') }}">
							</div>
							<span>{{$user->nama}}</span>
						</a>
						<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
							<li><a href="{{url('dashboard')}}" ><i class="icon-display"></i> Dashboard</a></li>
							<li><a href="{{url('logout')}}"><i class="icon-switch2"></i> Logout</a></li>
						  </ul>
					</div>
					{{-- <li class="dropdown dropdown-user">
						<a class="dropdown-toggle" data-toggle="dropdown">
							<img src="{{asset('assets/images/profil-photo.jpg')}}" alt="">
							<span>{{$user->nama}}</span>
						</a>
						<ul class="dropdown-menu dropdown-menu-right">
							<li><a href="{{url('dashboard')}}" ><i class="icon-display"></i> Dashboard</a></li>
							<li><a href="#modalPassword"  data-toggle="modal"><i class="icon-lock2"></i> Ubah Password</a></li>
							<li><a href="#modalTahun"  data-toggle="modal"><i class=" icon-calendar2"></i> Ubah Tahun</a></li>
							<li><a href="{{url('logout')}}"><i class="icon-switch2"></i> Logout</a></li>
						</ul>
					</li> --}}
					@else
						<a class="btn me-2" href="{{url('login')}}" style="border-radius:30px; background:#8C0C06; color:#fff">LOGIN</a>
					@endif
				</ul>
			</div>
		</div>
		<!-- Carousel -->
		<div id="demo" class="carousel slide" data-bs-ride="carousel">
		
			<!-- The slideshow/carousel -->
			<div class="carousel-inner">
				@php
					$no = 0;
				@endphp
				@foreach ($data['slider'] as $item)
				@php
					if ($no < 1) {
						$class_info = "active";
					}else{
						$class_info = null;
					}
				@endphp
				<div class="carousel-item {{ $class_info }}">
					<img src="{{asset('storage/'.$item->slider)}}" class="d-block w-100">
				</div>
				@php
					$no++;
				@endphp
				@endforeach
			</div>
		
			<!-- Left and right controls/icons -->
			<button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
				<span class="carousel-control-prev-icon"></span>
			</button>
			<button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
				<span class="carousel-control-next-icon"></span>
			</button>
		</div>
		<div style="background:#F4F6F7;" class="page-widget">
			<div class="row">
			<div class="col-md-5"><img src="{{url('storage/'.$data['single-post'][3]->content)}}" style="width:100%"></div>
			<div class="col-md-7">
				<h3 style="color:#000;font-size:35px">Tentang <span style="font-weight:bold;color:#ff9029">eLING</span></h3>
						<div style="color:#000;font-size:18px; text-align:justify">{!!$data['single-post'][1]->content!!}</div>
					</div>
			</div>
		</div>
		<div style="background:#FFFF;" class="page-widget">
			<div class="row">
			<div class="col-md-5">
				<h3 style="color:#000;font-size:35px">Cara Kerja <span style="font-weight:bold;color:#9a3300">eLING</span></h3>
						<div style="ccolor:#000;font-size:16px; text-align:justify">{!!$data['single-post'][2]->content!!}</div>
					</div>
			<div class="col-md-7"><img src="{{url('storage/'.$data['single-post'][4]->content)}}" style="width:100%"></div>
			</div>
		</div>
		<div style="background:#DA251D;" class="page-widget">

			<div class="row">
				<div class="col-md-4 pt-5" style="text-align:justify">
					<img src="{{asset('assets/images/logo.png')}}" style="width:80%"><br><br>
					<span style="font-size:18px; color:#fff">Jl. Pemuda Nomor 148 Semarang, Kel. Sekayu Kec. Semarang Tengah, Kota Semarang, Jawa Tengah 50132</span><br><br>
					<span style="font-size:18px;color:#fff">setda.baghukum2018@gmail.com<br>Telp: 024-3513366 ext. 1228, 1288, 1278<br></span>
				</div>
				
				<div class="col-md-4">
					<h3 style="color:#fff;font-size:35px">Tautan Lainnya</h3>
					<ul class="list-group list-group-flush" style="border:0px">
						<a class="list-group-item" style="font-size:18px;color:#000" href="http://semarangkota.go.id"><img src="{{asset('assets/images/mini.png')}}" width="25px" height="25px"/>&nbsp Kota Semarang</a>
						<a class="list-group-item" style="font-size:18px;color:#000" href="http://jdih.semarangkota.go.id"><img src="{{asset('assets/images/jdih.png')}}" width="25px" height="25px"/>&nbsp JDIH Kota Semarang</a>
					</ul>
					
				</div>
				<div class="col-md-4">
					<img src="{{asset('assets/images/bag_hukum_semarang.png')}}" style="width:100%">
					<div id="map" style="height:70%;width:100%"></div>
					<br><br><br>
				</div>

				<div class="col-md-6">
					
				</div>
			</div>
		</div>
		<div class="footer py-4 d-flex flex-lg-column" id="kt_footer" style="background:#da251d">
			<!--begin::Container-->
			<div class="navbar navbar-sm navbar-fixed-bottom" style="background:#da251d">
			  <!--begin::Copyright-->
			  <div class="navbar-text">
				<span class=" fw-bold me-1" style="color:#fff">© 2022</span>
				<a href="https://sevenmediatech.co.id/" target="_blank" style="color:#fff" class="text-hover-primary">ELING KOTA SEMARANG</a>
			  </div>
			  <!--end::Copyright-->
			</div>
			<!--end::Container-->
		</div>

		{{-- <script type="text/javascript" src="{{asset('assets/js/plugins/loaders/pace.min.js')}} "></script>
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
		<script type="text/javascript" src="{{asset('assets/js/core/app.js')}}"></script> --}}
		<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCwM97nQUK4yix9LHftPYOjMyQ0cAQP5kY&callback=initMap" type="text/javascript"></script>
		<!-- Theme JS files -->

		<script>
			function initMap() {
			var uluru = {lat: -6.98246, lng: 110.4111016};
			var map = new google.maps.Map(document.getElementById('map'), {
				zoom: 18,
				center: uluru
			});

			var contentString = '<div id="content">'+
				'<div id="siteNotice">'+
				'</div>'+
				'<h1 id="firstHeading" class="firstHeading">Kantor Bagian Hukum</h1>'+
				'<div id="bodyContent">'+
				'</div>'+
				'</div>';

			var infowindow = new google.maps.InfoWindow({
				content: contentString
			});

			var marker = new google.maps.Marker({
				position: uluru,
				map: map,
				title: 'Uluru (Ayers Rock)'
			});
			marker.addListener('click', function() {
				infowindow.open(map, marker);
			});
			}

			$(function(){
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
		</script>
		@yield('js')
	</body>
</html>
