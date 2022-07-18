<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LOGIN | ELING KOTA SEMARANG</title>
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
	<script src="{{asset('vendors/js/custom/authentication/sign-in/general.js')}}"></script>
</head>
<body id="kt_body" class="bg-body">
	<div class="d-flex flex-column flex-root">
		<!--begin::Authentication - Sign-in -->
		<div class="page-widget" style="background-image: url({{ asset('assets/images/bg-login.png') }})">
			<!--begin::Content-->
			<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
				<!--begin::Wrapper-->
				<div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
					<!--begin::Form-->
					<form action="{{url('login')}}" method="POST" class="form w-100" novalidate="novalidate" id="kt_sign_in_form">
						{{ csrf_field() }}
						<!--begin::Logo-->
						<a href="#" class="text-center mb-10">
							<center>
								<img alt="Logo" src="{{ asset('assets/images/logo_login.png') }}" Style="width: 40%" />
							</center>
						</a><br>
						<!--end::Logo-->
						<!--begin::Heading-->
						<div class="text-center mb-10">
							<!--begin::Title-->
							<h1 class="text-dark mb-3">Selamat Datang</h1>
							<h2>Silahkan login untuk akses</h2>
							<!--end::Title-->
						</div>
						<!--begin::Heading-->
						<!--begin::Input group-->
						<div class="fv-row mb-10">
							<!--begin::Label-->
							<label class="form-label fs-6 fw-bolder text-dark">Username</label>
							<!--end::Label-->
							<!--begin::Input-->
							<input class="form-control form-control-lg form-control-solid" type="text" id="username" name="username" autocomplete="off" />
							<!--end::Input-->
						</div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="fv-row mb-10">
							<!--begin::Wrapper-->
							<div class="d-flex flex-stack mb-2">
								<!--begin::Label-->
								<label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
								<!--end::Label-->
							</div>
							<!--end::Wrapper-->
							<!--begin::Input-->
							<input class="form-control form-control-lg form-control-solid" type="password" name="password" id="password" autocomplete="off" />
							<!--end::Input-->
						</div>
						<!--begin::Input group-->
						<div class="fv-row mb-10">
							<!--begin::Label-->
							<label class="form-label fs-6 fw-bolder text-dark">Tahun</label>
							<!--end::Label-->
							<!--begin::Input-->
							<select class="form-control form-control-lg form-select-solid" data-control="select2" name="tahun">
								@for($tahun=2015;$tahun<=date('Y');$tahun++)
								<option value="{{$tahun}}" @if($tahun==date('Y')) selected @endif >{{$tahun}}</option>
								@endfor
							</select>
							<!--end::Input-->
						</div>
						<!--end::Input group-->
						<!--begin::Actions-->
						<div class="text-center">
							<!--begin::Submit button-->
							<button type="submit" class="btn btn-lg btn-bg-danger text-white btn-login w-100 mb-5">
								<span class="indicator-label">LOGIN</span>
							</button>
						</div>
						<!--end::Actions-->
					</form>
					<!--end::Form-->
				</div>
				<!--end::Wrapper-->	
				<!--begin::Copyright-->
				<div class="navbar-text">
					<span class=" fw-bold me-1" style="color:#fff">© 2022</span>
					<a href="https://sevenmediatech.co.id/" target="_blank" style="color:#fff" class="text-hover-primary">e-Ling (Elektronik Legal Drafting) Kota Semarang</a>
				</div>
				<!--end::Copyright-->			
			</div>
			<!--end::Content-->
		</div>
		<!--end::Authentication - Sign-in-->
	</div>
	<script>
	$(function(){
			@if(\Illuminate\Support\Facades\Session::has('message'))
			swal.fire({
			icon: '{{ \Illuminate\Support\Facades\Session::get('message_type') }}',
			text: '{{ \Illuminate\Support\Facades\Session::get('message') }}',
			button: false,
			timer: 1500
			});
		@endif
	});
	</script>
</body>
</html>
