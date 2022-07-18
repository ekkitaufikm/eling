@include('include.function')
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cetak Bukti Register</title>
	<link href="{{asset('assets/css/laporan.css')}} " rel="stylesheet" type="text/css">
  <style>
  table tr td{
    vertical-align: top;
  }
  table tr td ul{
    margin: 0px 0px 0px 15px;
    padding: 0px
  }
  </style>
</head>
<body style="font-size:small">
  <h2 style="text-align:center">CETAK BUKTI REGISTER PRODUK HUKUM</h2>
  <table>
     <tr>
      <td>Jenis Produk Hukum</td>
      <td>:</td>
      <td>{{$data['produk-hukum']->jenis_produk_hukum}}</td>
    </tr>
    <tr>
      <td>Judul Produk Hukum</td>
      <td>:</td>
      <td>{{$data['produk-hukum']->judul}}</td>
    </tr>
    <tr>
      <td>Perangkat Daerah Pengusul</td>
      <td>:</td>
      <td>{{$data['produk-hukum']->satker}}</td>
    </tr>
    <tr>
      <td width="180px">No. Register</td>
      <td width="10px">:</td>
      <td>{{$data['produk-hukum']->nomor}}</td>
    </tr>
    
<!--    <tr>
      <td>Pejabat Penetap</td>
      <td>:</td>
      <td>{{$data['produk-hukum']->pejabat_penetap}}</td>
    </tr>-->
    <tr>
      <td>Deskripsi</td>
      <td>:</td>
      <td>{{$data['produk-hukum']->deskripsi}}</td>
    </tr>
    <tr>
      <td style="font-weight:bold">Checklist</td>
      <td>:</td>
      <td>
          <table>
        <tr>
            <td style="border:1px solid black;width:15px"></td>
            <td>@if($data['produk-hukum']->fid_jenis_produk_hukum==3) Di cetak rangkap 3 @else Di cetak rangkap 2 @endif</td>
        </tr>
        <tr>
            <td style="border:1px solid black;width:15px"></td>
            <td>@if($data['produk-hukum']->fid_jenis_produk_hukum==3) 1 rangkap (tanpa materai) di paraf per lembar + lampiran (jika ada) oleh kepala OPD/pejabat yang mengajukan @else 1 rangkap di paraf per lembar + lampiran (jika ada) oleh kepala OPD/pejabat yang mengajukan @endif</td>
        </tr>
        @if($data['produk-hukum']->fid_jenis_produk_hukum==3)
         <tr>
            <td style="border:1px solid black;width:15px"></td>
            <td> 1 rangkap diberi materai di PIHAK KESATU</td>
        </tr>
        <tr>
            <td style="border:1px solid black;width:15px"></td>
            <td> 1 rangkap diberi materai di PIHAK KEDUA</td>
        </tr>
        @endif
        <tr>
            <td style="border:1px solid black;width:15px"></td>
            <td>Nota Dinas</td>
        </tr>
        @if($data['produk-hukum']->fid_pejabat_penetap==1)
        <tr>
            <td style="border:1px solid black;width:15px"></td>
            <td>Baju Surat</td>
        </tr>
        @endif
            </table>
      </td>
    </tr>
  </table>
	<table class="tabl" style="width:100%;margin-top:20px">
		<thead>
			<tr>
				<th>No</th>
				<th>Tanggal / Waktu</th>
				<th>Kendali Produk Hukum</th>
				<th style="width:45%">Catatan</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($data['kendali'] as $key => $value)
				<tr>
					<td style="width:1px;white-space:nowrap">{{$key+1}}</td>
					<td style="width:1px;white-space:nowrap">{{tgl_indo($value->tanggal)}}, {{dateFormat($value->tanggal,'H:i:s')}}</td>
					<td style="text-align:left">{!!$value->perintah!!}</td>
					<td style="width:1px">@if(!empty($value->catatan)){{$value->catatan}}@else Tidak Ada Catatan @endif</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	<table class="tabl" style="width:100%;margin-top:20px">
	    <thead>
	        <tr>
				<th>No</th>
				<th>Tanggal / Waktu</th>
				<th>Kendali Produk Hukum</th>
				<th>Paraf</th>
			</tr>
	    </thead>
	    <tbody>
	        <tr>
				<td style="width:1px;white-space:nowrap">1.</td>
				<td style="width:15%;white-space:nowrap"></td>
				<td style="text-align:left"><b>Diterima Bagian Hukum</b></td>
				<td style="width:15%;white-space:nowrap"></td>
			</tr>
			<tr>
				<td style="width:1px;white-space:nowrap">2.</td>
				<td style="width:1px;white-space:nowrap"></td>
				<td style="text-align:left"><b>Asisten Pemerintahan Sekda Kota Semarang</b></td>
				<td style="width:1px;white-space:nowrap"></td>
			</tr>
			<tr>
				<td style="width:1px;white-space:nowrap">3.</td>
				<td style="width:1px;white-space:nowrap"></td>
				<td style="text-align:left"><b>Sekretaris Daerah Kota Semarang</b></td>
				<td style="width:1px;white-space:nowrap"></td>
			</tr>
			<tr>
				<td style="width:1px;white-space:nowrap">4.</td>
				<td style="width:1px;white-space:nowrap"></td>
				<td style="text-align:left"><b>Walikota Semarang</b></td>
				<td style="width:1px;white-space:nowrap"></td>
			</tr>
	    </tbody>
	</table>
	<h3>Telah dianalisa Bagian Hukum melalui <i>Elektronik Legal Drafting (eLing System)</i></h3>
</body>
</html>
