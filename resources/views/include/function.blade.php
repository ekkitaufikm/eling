<?php
function nama_hari($tgl){
  $day = date('D', strtotime($tgl));
  $dayList = array(
    'Sun' => 'Minggu',
    'Mon' => 'Senin',
    'Tue' => 'Selasa',
    'Wed' => 'Rabu',
    'Thu' => 'Kamis',
    'Fri' => 'Jumat',
    'Sat' => 'Sabtu'
  );
  return $dayList[$day];
}

function dateFormat($date,$format){
  $date=date_create($date);
  $date_new=date_format($date,$format);
  return $date_new;
}

function tgl_indo($tgl){
	$tanggal = substr($tgl,8,2);
	$bulan = getBulan(substr($tgl,5,2));
	$tahun = substr($tgl,0,4);
	return $tanggal.' '.$bulan.' '.$tahun;
}

function tgl_indo_singkatan($tgl){
	$tanggal = substr($tgl,8,2);
	$bulan = getBulanSinkatan(substr($tgl,5,2));
	$tahun = substr($tgl,0,4);
	return $tanggal.' '.$bulan.' '.$tahun;
}

function getBulanSinkatan($bln){
	switch ($bln){
		case 1:
			return "JAN";
			break;
		case 2:
			return "FEB";
			break;
		case 3:
			return "MAR";
			break;
		case 4:
			return "APR";
			break;
		case 5:
			return "MEI";
			break;
		case 6:
			return "JUN";
			break;
		case 7:
			return "JUL";
			break;
		case 8:
			return "AGS";
			break;
		case 9:
			return "SEP";
			break;
		case 10:
			return "OKT";
			break;
		case 11:
			return "NOV";
			break;
		case 12:
			return "DES";
			break;
	}
}

function getBulan($bln){
	switch ($bln){
		case 1:
			return "Januari";
			break;
		case 2:
			return "Februari";
			break;
		case 3:
			return "Maret";
			break;
		case 4:
			return "April";
			break;
		case 5:
			return "Mei";
			break;
		case 6:
			return "Juni";
			break;
		case 7:
			return "Juli";
			break;
		case 8:
			return "Agustus";
			break;
		case 9:
			return "September";
			break;
		case 10:
			return "Oktober";
			break;
		case 11:
			return "November";
			break;
		case 12:
			return "Desember";
			break;
	}
}
?>
