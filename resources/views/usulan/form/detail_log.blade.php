<div class="col-xl-12 mt-5">
    <div class="card card-xl-stretch">
      <div class="card-body bg-secondary">
        <div class="row mb-10">
          <div class="text-center mb-6">
            <h2>{{ $data['produk']->judul }}</h2>
          </div>
          <h3>Daftar Log Lampiran & Kendali Ulasan</h3>
          <div class="col-sm-12 bg-white mt-4 row">
            <div class="table-responsive">
              <table class="table table-striped table-row-bordered align-middle gy-5 gs-7" id="tabel_satker">
                <thead class="fw-bolder">
                  <tr>
                    <th data-priority="1">No</th>
                    <th>Pengguna</th>
                    <th>Jenis</th>
                    <th>Aktivitas</th>
                    <th>Waktu</th>
                  </tr>
                </thead>
                <tbody id="main-bdy" class="fw-bold">
                    @foreach ($data['data_log'] as $item)
                    @php
                        if(!empty($item->lampiran_log)){
                            if (!empty($item->judul)) {
                                $ket = "Lampiran Produk Hukum : ".$item->judul;
                            }else{
                                if ($item->attachment) {
                                    $ket = "Lampiran Produk Hukum : ".$item->attachment;
                                } else {
                                    $ket = "Lampiran Produk Hukum : ".$item->link_attachment;
                                }
                            }
                            
                        }else{
                            $ket = "Usulan Produk Hukum";
                        }
                    @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->user->nama }}</td>
                            <td>{{ $ket }}</td>
                            <td>{{ $item->ket_log }}</td>
                            <td>{{ $item->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>