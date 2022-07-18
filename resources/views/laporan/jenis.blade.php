<div class="col-xl-12 mt-5">
  <div class="card card-xl-stretch">
    <div class="card-body bg-secondary">
      <div class="row mb-10">
        <div class="table-responsive">
          <table class="table table-striped table-row-bordered align-middle gy-5 gs-7">
            <thead class="fw-bolder">
              <tr>
                <th rowspan="2" width="50px">NO</th>
                <th rowspan="2">SATUAN KERJA</th>
                <th colspan="2">JENIS PRODUK HUKUM</th>
                <th rowspan="2">JUMLAH PRODUK HUKUM</th>
              </tr>
              <tr>
                @foreach ($master['klasifikasi'] as $key => $value)
                <th>{{$value->jenis_produk_hukum}}</th>
                @endforeach
              </tr>
            </thead>
            <tbody class="fw-bold">
              @foreach ($data['satker'] as $key => $value)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$value->nama}}</td>
                @foreach ($value->jenis as $key2 => $value2)
                <td>{{$value2->jumlah}}</td>
                @endforeach
                <td>{{$value->jumlah}}</td>
              </tr>
              @endforeach
              <tr>
                <td colspan="2">JUMLAH</td>
                @foreach ($data['rekap-jenis-jumlah'] as $key => $value)
                <td>{{$value->jumlah}}</td>
                @endforeach
                <td>{{$data['jumlah-produk-jenis']}}</td>
              </tr>
            </tbody>
          </table>          
        </div>
      </div>
    </div>
  </div>
</div>
