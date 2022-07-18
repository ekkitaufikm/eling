<div class="col-xl-12 mt-5">
  <div class="card card-xl-stretch">
    <div class="card-body bg-secondary">
      <div class="row mb-10">
        <div class="table-responsive">
          <table class="table table-striped table-row-bordered align-middle gy-5 gs-7">
            @php
                  $nama_bulan = array ('Jan', 'Feb', 'Mar', 'Apr' , 'Mei' , 'Jun' , 'Jul' , 'Ags' , 'Sep' , 'Okt' , 'Nov' , 'Des');
                  $bulan = array ('01', '02', '03', '04' , '05' , '06' , '07' , '08' , '09' , '10' , '11' , '12');
            @endphp
            <thead class="fw-bolder">
              <tr>
                  <th rowspan="3">No</th>
                  <th rowspan="3" style="text-align:center">Jenis Produk Hukum</th>
                  <th colspan="24" style="text-align:center">Bulan</th>
              </tr>
              <tr>
                  @foreach ($nama_bulan as $value)
                  <th colspan="2" style="text-align:center">{{$value}}</th>
                  @endforeach
              </tr>
              <tr>
                  @for ($i = 0; $i < 12; $i++)
                  <th style="text-align:center">Masuk</th>
                  <th style="text-align:center">Register</th>
                  @endfor
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>