@if (count($errors) > 0)
<div class="alert alert-danger">
	<ul>
		@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif

<div class="col-md-12 mt-5">
	<div class="card card-xl-stretch">
		<form action="{{url('usulan/produk/proses')}}" method="POST" enctype="multipart/form-data">
		<div class="card-body bg-secondary">
			<div class="mb-10">
					{{ csrf_field() }}
					<input type="hidden" name="id" value="{{$id}}">
					<input type="hidden" name="action" value="@if (!empty($data['produk'])) 'edit' @else 'add' @endif">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-form-label">Judul Produk Hukum: </label>
								<textarea class="form-control" name="judul" style="height:150px" required >@if(!empty($data['produk'])){{$data['produk']->judul}}@endif</textarea>
							</div>
							<div class="form-group">
								<label class="col-form-label">Jenis Produk Hukum:</label>
								<select name="jenis" class="form-select" data-control="select2">
									@foreach ($master['jenis-produk-hukum'] as $key => $value)
											<option value="{{$value->id}}" @if(!empty($data['produk'])) @if($data['produk']->fid_jenis_produk_hukum==$value->id) selected @endif @endif >{{$value->jenis_produk_hukum}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label class="col-form-label" for="">Kategori Produk Hukum :</label>
								<select name="kategori_katprod" id="kategori_katprod" class="form-select" data-control="select2">
									@foreach ($master['kategori-produk-hukum'] as $key => $value)
										<option value="{{ $value->id_katprod }}" {{ ($value->id_katprod==@$data['produk']->kategori_katprod) ? "SELECTED" : "" }}>{{ $value->nama_katprod }}</option>
									@endforeach
								</select>
							</div>
							  <div class="form-group">
								<label class="col-form-label">Pejabat Penetap:</label>
								<select name="pejabat_penetap" class="form-select" data-control="select2">
									@foreach ($master['pejabat-penetap'] as $key => $value)
										<option value="{{$value->id}}" @if(!empty($data['produk'])) @if($data['produk']->pejabat_penetap==$value->id) selected @endif @endif >{{$value->pejabat_penetap}}</option>
									@endforeach
								</select>
							</div>
							  <div class="form-group">
								<label class="col-form-label">Deskripsi Singkat : </label>
								<textarea class="form-control" name="deskripsi" >@if(!empty($data['produk'])){{$data['produk']->deskripsi}}@endif</textarea>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group mt-13">
								<input name="attachment" class="form-control" type="file">
								{{-- <div class="dropzone" id="kt_dropzonejs_example_1">
									<!--begin::Message-->
									<div class="dz-message needsclick">
										<!--begin::Icon-->
										<i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
										<!--end::Icon-->
						
										<!--begin::Info-->
										<div class="ms-4">
											<h3 class="fs-5 fw-bolder text-gray-900 mb-1">Drop files here or click to upload.</h3>
											<span class="fs-7 fw-bold text-gray-400">Upload Files Doc Atau Docx</span>
										</div>
										<!--end::Info-->
									</div>
								</div> --}}
							</div>
							<div class="form-group mb-6">
								<label class="col-form-label">Link Upload (Google Drive/Dropbox/dll)</label>
								<input type="text" name="link_attachment" id="link_attachment" value="{{ (!empty($data['produk']->link_attachment)) ? $data['produk']->link_attachment : null }}" class="form-control">
							</div>
							<div class="form-group mb-6">
								<label class="col-form-label">Nomor Penanggung Jawab</label>
								<input type="text" name="no_pj" id="no_pj" value="{{ (!empty($data['produk']->no_pj)) ? $data['produk']->no_pj : null }}" class="form-control">
							</div>
							<div class="form-group mb-6">
								<label class="col-form-label">Nama Penanggung Jawab</label>
								<input type="text" name="nama_pj" id="nama_pj" value="{{ (!empty($data['produk']->nama_pj)) ? $data['produk']->nama_pj : null }}" class="form-control">
							</div>
							<h5>Mohon Lampirkan</h5>
							<ul>
							  <li>SK Induk apabila pengajuan SK Perubahan</li>
							  <li>Peraturan dan administrasi pendukungnya bisa upload diluar draft</li>
							  <li>Peraturan pendukung bisa dalam bentuk file atau sebutkan no & tahunnya</li>
							</ul>
						</div>
					</div>
					
				
			</div>
		</div>
		<div class="card-footer float-end">
			<a href="{{url('usulan/tampil')}}" class="btn btn-light">Tutup</a>
			<button type="submit" id="uploadFile" class="btn btn-danger">@if(Session::get('useractive')->hak_akses == 5) Simpan @else Perbarui @endif</button>
		</div>
		</form>
	</div>
</div>

{{-- <form action="{{url('usulan/produk/proses')}}" method="POST" enctype="multipart/form-data">
  {{ csrf_field() }}
	<div class="row">
		<div class="col-md-6">
      <div class="form-group">
				<label>Judul Produk Hukum: </label>
				<textarea class="form-control" name="judul" style="height:150px" required >@if(!empty($data['produk'])){{$data['produk']->judul}}@endif</textarea>
			</div>
      <div class="form-group">
				<label>Jenis Produk Hukum:</label>
				<select name="jenis" class="select2">
          @foreach ($master['jenis-produk-hukum'] as $key => $value)
            <option value="{{$value->id}}" @if(!empty($data['produk'])) @if($data['produk']->fid_jenis_produk_hukum==$value->id) selected @endif @endif >{{$value->jenis_produk_hukum}}</option>
          @endforeach
				</select>
			</div>
			<div class="form-group">
				<label for="">Kategori Produk Hukum :</label>
				<select name="kategori_katprod" id="kategori_katprod" class="select2">
					@foreach ($master['kategori-produk-hukum'] as $key => $value)
						<option value="{{ $value->id_katprod }}" {{ ($value->id_katprod==@$data['produk']->kategori_katprod) ? "SELECTED" : "" }}>{{ $value->nama_katprod }}</option>
					@endforeach
				</select>
			</div>
      <div class="form-group">
				<label>Pejabat Penetap:</label>
				<select name="pejabat_penetap" class="select2">
          @foreach ($master['pejabat-penetap'] as $key => $value)
            <option value="{{$value->id}}" @if(!empty($data['produk'])) @if($data['produk']->pejabat_penetap==$value->id) selected @endif @endif >{{$value->pejabat_penetap}}</option>
          @endforeach
				</select>
			</div>
      <div class="form-group">
				<label>Deskripsi Singkat : </label>
				<textarea class="form-control" name="deskripsi" >@if(!empty($data['produk'])){{$data['produk']->deskripsi}}@endif</textarea>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Draft Produk Hukum @if(!empty($data['produk']) && !empty($data['produk']->attachment))(<a href="{{asset('storage/'.$data['produk']->attachment)}}" target="_BLANK">DOWNLOAD DRAFT</a>) @endif:</label>
        <input name="attachment" class="dropify" type="file" data-allowed-file-extensions="doc docx">
				<div style="font-style:italic;font-size:13px;color:#d94e00">Draft Produk Hukum Wajib Ms.Word</div>
			</div>
			<div class="form-group">
				<label for="">Link Upload (Google Drive/Dropbox/dll)</label>
				<input type="text" name="link_attachment" id="link_attachment" value="{{ (!empty($data['produk']->link_attachment)) ? $data['produk']->link_attachment : null }}" class="form-control">
			</div>
      <h5>Mohon Lampirkan</h5>
      <ul>
        <li>SK Induk apabila pengajuan SK Perubahan</li>
        <li>Peraturan dan administrasi pendukungnya bisa upload diluar draft</li>
        <li>Peraturan pendukung bisa dalam bentuk file atau sebutkan no & tahunnya</li>
      </ul>
		</div>
    <input type="hidden" name="id" value="{{$id}}">
    <input type="hidden" name="action" value="@if (!empty($data['produk'])) 'edit' @else 'add' @endif">
	</div>
	<div class="text-right">
		<a href="{{url('usulan/tampil')}}" class="btn btn-default">Tutup</a>
		<button type="submit" class="btn btn-warning">@if(Session::get('useractive')->hak_akses == 5) Simpan @else Perbarui @endif</button>
		
	</div>
</form> --}}
<script>
	$(function () {
		// Dropzone.autoDiscover = false;
		var myDropzone = new Dropzone("#kt_dropzonejs_example_1", {
			// autoProcessQueue: false,
			url: "/usulan/file-upload?type=usulan_produk",
			acceptedFiles: ".docx,.doc",
			paramName: "files", // The name that will be used to transfer the file
			maxFiles: 1,
			maxFilesize: 10, // MB
			addRemoveLinks: true,
			success: function (file, response) {
                console.log(response);
            }
			// accept: function(file, done) {
			// 	if (file.name == "wow.jpg") {
			// 		done("Naha, you don't.");
			// 	} else {
			// 		done();
			// 	}
			// }
		});
		  

		// $('#uploadFile').click(function(){
		// 	myDropzone.processQueue();
		// });
	})
</script>