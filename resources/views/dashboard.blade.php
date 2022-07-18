{{-- config session --}}
@php
$user=Session::get('useractive');
if ($user->hak_akses!="5") {
  $display_all = null;
  $display_opd = "none";
}else{
  $display_opd = null;
  $display_all = "none";
}
@endphp
{{-- end config session --}}

@php($page='dashboard')
@php($subpage='dashboard')
@php
use Illuminate\Support\Facades\Session;
@endphp
@extends('layout.main')
@section('title')
  Dashboard | eLing KOTA SEMARANG
@endsection
@section('css')
<style>
.table thead tr th{
  text-align: center;
  font-weight: 600;
}
.text-center img{
    border-radius:10px;
}
.modal-body{
    padding:0px 20px 20px 20px;
}
</style>
@endsection
{{-- load page title --}}
@section('page-title')
    Dashboard
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
  <li class="breadcrumb-item text-white opacity-75">Dashboards</li>
  <!--end::Item-->
@endsection
{{-- end load page breadcrumb --}}
@section('content') 
{{-- total pekerjaan --}}
<div class="col-xl-4">
  <div class="card card-xl-stretch mb-xl-3">
    <div class="card-body">
      <div class="row mb-7">
        <h3>Hello, {{ $user->nama }}</h3>
        <p>@if ($data['total-job-deliv']==0) Tidak Ada @else Ada @endif {{ $data['total-job-deliv'] }} Pekerjaan yang harus kamu selesaikan</p>
        <div class="col-md-6 h-200px mt-7 mb-7">
          <div class="card h-200px card-xl-stretch bg-light">
            <div class="card-body d-flex flex-column justify-content-between">
              <div class="d-flex flex-column">
                <div class="text-black fw-bolder fs-1 mb-0 mt-5">{{ count($data['total-usulan-produk-semua']) }}</div>
                <div class="text-black fw-bold fs-6">Usulan Produk Hukum</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 h-200px mt-7 mb-7">
          <div class="card h-200px card-xl-stretch bg-light">
            <div class="card-body d-flex flex-column justify-content-between">
              <div class="d-flex flex-column">
                <div class="text-black fw-bolder fs-1 mb-0 mt-5">{{ $data['total-usulan-produk-kabag'] }}</div>
                <div class="text-black fw-bold fs-6">Disposisi Kabag</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 h-200px mt-7">
          <div class="card h-200px card-xl-stretch bg-light">
            <div class="card-body d-flex flex-column justify-content-between">
              <div class="d-flex flex-column">
                <div class="text-black fw-bolder fs-1 mb-0 mt-5">{{ $data['total-usulan-produk-kasubag'] }}</div>
                <div class="text-black fw-bold fs-6">Disposisi Kasubag</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 h-200px mt-7">
          <div class="card h-200px card-xl-stretch bg-light">
            <div class="card-body d-flex flex-column justify-content-between">
              <div class="d-flex flex-column">
                <div class="text-black fw-bolder fs-1 mb-0 mt-5">{{ $data['total-usulan-produk-staff'] }}</div>
                <div class="text-black fw-bold fs-6">Disposisi Staff</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- end total pekerjaan --}}

<div class="col-xl-8">
  <div class="row gx-5 gx-xl-8 mb-5 mb-xl-8">
    {{-- total produk --}}
    <div class="col-xl-7 mb-7" style="display: {{ $display_all }}">
      <div class="card bgi-no-repeat bgi-size-cover card-xl-stretch">
        <div class="card-body">
          <div class="row mb-7 mt-5">
            <h3>{{ count($data['total-usulan-produk-semua']) }}</h3>
            <h3>Total Produk Hukum Tahun 2022</h3>
            <div class="col-md-5 mt-5">
              <canvas id="data-produk-hukum"></canvas>
            </div>
            <div class="col-md-7 mt-5">
              <div class="d-flex flex-column mb-2 mt-15">
                <div class="text-black fw-bold"><i style="color: #50CD89" class="fas fa-circle"></i> Produk Hukum Terselesaikan {{ count($data['total-produk-selesai']) }}</div>
              </div>
              <div class="d-flex flex-column mb-2">
                <div class="text-black fw-bold"><i style="color: #009EF7" class="fas fa-circle"></i> Produk Hukum Dalam Proses {{ count($data['total-produk-proses']) }}</div>
              </div>
              <div class="d-flex flex-column">
                <div class="text-black fw-bold"><i style="color: #D9D9D9;" class="fas fa-circle"></i> Produk Hukum Gagal {{ count($data['total-produk-gagal']) }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-- end total produk --}}
    {{-- link cepat --}}
    <div class="col-xl-5 mb-7" style="display: {{ $display_all }}">
      <div class="card bgi-no-repeat bgi-size-cover card-xl-stretch">
        <div class="card-body">
          <div class="row">
            <h3>Link Cepat</h3>
            <div class="col-md-12 mb-3 mt-2">
              <div class="card card-sm-stretch bg-light">
                <div class="card-body d-flex flex-column justify-content-between">
                  <div class="d-flex flex-column">
                    <div class="text-black text-center fw-bold fs-6">Rekap Produk Hukum</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12 mb-3">
              <a href="{{url('usulan')}}">
                <div class="card card-sm-stretch bg-light">
                  <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex flex-column">
                      <div class="text-black text-center fw-bold fs-6">Usulan Produk Hukum</div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-md-12 mb-2">
              <a href="{{url('produk')}}">
                <div class="card card-sm-stretch bg-light">
                  <div class="card-body d-flex flex-column justify-content-between">
                    <div class="d-flex flex-column">
                      <div class="text-black text-center fw-bold fs-6">Produk Hukum</div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-- end link cepat --}}
  
  {{-- link ajukan produk hukum --}}
  <div class="col-xl-4 mb-7" style="display: {{ $display_opd }}">
    <div class="card bgi-no-repeat bg-danger bgi-size-cover card-xl-stretch">
      <div class="card-body">
        <div class="row">
          <h3 class="text-white mt-20 mb-9">Ajukan Produk Hukum</h3>
          <a href="/usulan/form" class="btn btn-light">
            Ajukan Sekarang
          </a>
        </div>
      </div>
    </div>
  </div>
  {{-- end link ajukan produk hukum --}}
  {{-- link progress hukum --}}
  <div class="col-xl-4 mb-7" style="display: {{ $display_opd }}">
    <div class="card bgi-no-repeat bg-danger bgi-size-cover card-xl-stretch">
      <div class="card-body">
        <div class="row">
          <h3 class="text-white mt-20">Lihat Progres Produk Hukum</h3>
          <a href="/usulan" class="btn btn-light">Lihat Sekarang</a>
        </div>
      </div>
    </div>
  </div>
  {{-- end link progress hukum --}}
  {{-- link laporan hukum --}}
  <div class="col-xl-4 mb-7" style="display: {{ $display_opd }}">
    <div class="card bgi-no-repeat bg-danger bgi-size-cover card-xl-stretch">
      <div class="card-body">
        <div class="row">
          <h3 class="text-white mt-20">Lihat Laporan Produk Hukum</h3>
          <a href="/laporan" class="btn btn-light">Lihat Sekarang</a>
        </div>
      </div>
    </div>
  </div>
  {{-- end link laporan hukum --}}
    
  {{-- banner --}}
  <div class="col-md-12">
    <div class="card card-xl-stretch">
      <div class="card-body">
        <div class="row mb-2">
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
                  @foreach ($data['slider'] as $item_slider)
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
              @foreach ($data['slider'] as $item_slider)
              @php
                  if ($no < 1) {
                    $class_slider = "active";
                  }else{
                    $class_slider = null;
                  }
              @endphp
              <!--begin::Item-->
              <div class="carousel-item {{ $class_slider }}">
                <img src="{{asset('storage/'.$item_slider->slider)}}" width="100%" class="mb-10 mt-10">
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
      </div>
    </div>
  </div>
  {{-- end banner --}}
  </div>
</div>

{{-- Rekapitulasi --}}
<div class="col-xl-12" style="display: {{ $display_all }}">
  <div class="card card-xl-stretch">
    <div class="card-body">
      <div class="text-center">
        <h5><b>REKAPITULASI PRODUK HUKUM
          <br>BAGIAN HUKUM SEKRETARIAT DAERAH KOTA SEMARANG
          <br>TAHUN {{Session::get('yearactive')}}</b></h5>
      </div>
      <div class="table-responsive">
        @php
        $nama_bulan = array ('Jan', 'Feb', 'Mar', 'Apr' , 'Mei' , 'Jun' , 'Jul' , 'Ags' , 'Sep' , 'Okt' , 'Nov' , 'Des');
        $bulan = array ('01', '02', '03', '04' , '05' , '06' , '07' , '08' , '09' , '10' , '11' , '12');
        @endphp
        <table class="table table-striped table-row-bordered align-middle gy-5 gs-7">
          <thead class="fw-bolder">
            <tr>
              <th rowspan="2">No</th>
              <th rowspan="2">Jenis Produk Hukum</th>
              <th colspan="12">Bulan</th>
              <th rowspan="2">Jumlah</th>
              <th rowspan="2">Keterangan</th>
            </tr>
            <tr>
              @foreach ($nama_bulan as $value)
                <th>{{$value}}</th>
              @endforeach
            </tr>
          </thead>
          <tbody class="fw-bold">
            @php 
              $masterController = new \App\Http\Controllers\MasterController(); 
            @endphp
            @foreach ($data['jenis-produk-hukum'] as $key => $value)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$value->jenis_produk_hukum}}</td>
                @foreach ($bulan as $value2)
                <td>{{$value->nilai[$value2]}}</td>
                @endforeach
                <td>{{$value->nilai_total}}</td>
                <td></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
{{-- end Rekapitulasi --}}

{{-- chart --}}
<div class="col-xl-12" style="display: {{ $display_all }}">
  <div class="card card-xl-stretch">
    <div class="card-body">
      <div class="row mb-7">
        <canvas id="data-rekapitulasi" style="height:300px"></canvas>
      </div>
    </div>
  </div>
</div>
{{-- end chart --}}
<div class="modal fade" tabindex="-1" id="kt_modal_1">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-body">
            <div class="text-center">
              {{-- <img src="https://eling.semarangkota.go.id/development/assets/images/banner-update.jpg" alt="images-modal" width="100%" class="mb-10 mt-10"> --}}
            </div>
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
                    @foreach ($data['info'] as $item)
                    @php
                        if ($no < 1) {
                          $class_indikator_info = "active";
                        }else{
                          $class_indikator_info = null;
                        }
                    @endphp
                      <li data-bs-target="#kt_carousel_1_carousel" data-bs-slide-to="{{ $no }}" class="ms-{{ $no }} {{ $class_indikator_info }}"></li>
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
                @foreach ($data['info'] as $item)
                @php
                    if ($no < 1) {
                      $class_info = "active";
                    }else{
                      $class_info = null;
                    }
                @endphp
                <!--begin::Item-->
                <div class="carousel-item {{ $class_info }}">
                  <img src="{{asset('storage/'.$item->file_informasi)}}" width="100%" class="mb-10 mt-10">
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
      </div>
  </div>
</div>
@endsection
@section('js')
<script>
  $(function () {
    $('#kt_modal_1').modal('show');
  })
     function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? ',' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
      x1 = x1.replace(rgx, '$1' + '.' + '$2');
    }
    return x1 + x2;
  }
  

  var ctx_produk_hukum = document.getElementById('data-produk-hukum');
  // Chart data
  const data_produk_hukum = {
    labels: [
      'Produk Hukum Terselesaikan',
      'Produk Hukum Dalam Proses',
      'Produk Hukum Gagal'
    ],
    datasets: [{
      label: 'My First Dataset',
      data: [{{ count($data['total-produk-selesai']) }}, {{ count($data['total-produk-proses']) }}, {{ count($data['total-produk-gagal']) }}],
      backgroundColor: [
        '#50CD89',
        '#009EF7',
        '#D9D9D9'
      ],
      hoverOffset: 4
    }]
  };

  // Chart config
  const config_produk_hukum = {
      type: 'doughnut',
      data: data_produk_hukum,
      options: {
        plugins: {
            legend: {
                display: false,
                position:'right',
            },
            tooltip: {
                // Disable the on-canvas tooltip
                enabled: false,
            }
        }
      }
  };

  // Init ChartJS -- for more info, please visit: https://www.chartjs.org/docs/latest/
  var myChart = new Chart(ctx_produk_hukum, config_produk_hukum);

  var iknbasuransi = document.getElementById('data-rekapitulasi').getContext('2d');
  var iknb_asur_chart = new Chart(iknbasuransi, {
    // The type of chart we want to create
    type: 'line', // also try bar or other graph types

    // The data for our dataset
    data: {
      labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
      // Information about the dataset
      datasets: [{
          label: "Keputusan Walikota",
          backgroundColor: "rgba(112,173,70,0.7)",
          borderColor: "rgba(112,173,70,0.7)",
          data: [
            <?php
                foreach($data['jenis-produk-hukum'] as $key => $value){
                  if($value->jenis_produk_hukum=="Keputusan Sekda" || $value->jenis_produk_hukum=="Naskah Perjanjian Hibah Daerah"){
                    continue;
                  }
                  foreach ($bulan as $value2) {
                    echo $value->nilai[$value2].',';
                  }
                }
            ?>        
          ],
        },
        {
          label: "Keputusan Sekda",
          backgroundColor: "rgba(89,155,213,0.7)",
          borderColor: "rgba(89,155,213,0.7)",
          data: [
            <?php
                foreach($data['jenis-produk-hukum'] as $key => $value){
                  if($value->jenis_produk_hukum=="Keputusan Walikota" || $value->jenis_produk_hukum=="Naskah Perjanjian Hibah Daerah"){
                    continue;
                  }
                  foreach ($bulan as $value2) {
                    echo $value->nilai[$value2].',';
                  }
                }
            ?>        
          ],
        },
        {
          label: "Naskah Perjanjian Hibah Daerah",
          backgroundColor: "rgba(255,193,57,0.7)",
          borderColor: "rgba(255,193,57,0.7)",
          data: [
            <?php
                foreach($data['jenis-produk-hukum'] as $key => $value){
                  if($value->jenis_produk_hukum=="Keputusan Walikota" || $value->jenis_produk_hukum=="Keputusan Sekda"){
                    continue;
                  }
                  foreach ($bulan as $value2) {
                    echo $value->nilai[$value2].',';
                  }
                }
            ?>        
          ],
        }
      ]
    },

    // Configuration options
    options: {
      layout: {
        padding: 10,
      },
      legend: {
        position: 'bottom',
      },
      title: {
        display: true,
        text: 'Data Rekapitulasi Produk Hukum'
      },
      tooltips: {
        callbacks: {
          label: function(tooltipItem, data) {
            var val = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
            return data.datasets[tooltipItem.datasetIndex].label + " : " + addCommas(Math.abs(val));
          }
        }
      },
      scales: {
        yAxes: [{
          stacked: false,
          ticks: {
            // Include a dollar sign in the ticks
            callback: function(value, index, values) {
              return '' + value;
            }
          },
          scaleLabel: {
            display: false,
            labelString: '(Rp juta)'
          }
        }],
        xAxes: [{
          stacked: false
        }]
      },
      responsive: true,
      maintainAspectRatio: false
    }
  });
</script>
@endsection