<div class="col-xl-12 mt-5">
  <div class="card card-xl-stretch">
    <div class="card-body bg-secondary">
      <div class="row mb-10">
        <div class="text-center mb-6">
          <h2>{{ $data['produk']->judul }}</h2>
        </div>
        {{-- kendali usulan --}}
        <div class="col-md-6">
          <div class="row">
            <div class="col-sm-6">
              <h3>Kendali Usulan</h3>
            </div>
            <div class="col-sm-6">
              <button class="btn float-end btn-danger" onclick="hide()">
                <i class="fa fa-plus-square text-white text-active-primary"></i>
                 Tambah Kendali
              </button>
            </div>
          </div>
          {{-- form tambah kendali --}}
          @php
              if(!empty(request()->query('detailkendali'))){
                $display = "";
              }else{
                $display = "none";
              }
          @endphp
          <div id="toHide" class="col-sm-12 bg-light mt-4 row" style="display: {{ $display }}">
            <label class="col-form-label text-black">{{(!empty($data['kendali-detil']) ? 'Edit' : 'Tambah')}} Kendali Usulan</label>
            <form class="row" action="{{url('usulan/kendali/proses')}}" method="POST" enctype="multipart/form-data" >
              {{ csrf_field() }}
              <input type="hidden" name="id_usulan" value="{{$id}}">
              <input type="hidden" name="id" value="{{$id_kendali}}">
              <input type="hidden" name="action" value="{{(!empty($data['kendali-detil']) ? 'edit' : 'add')}}">
              <div class="form-group mb-5">
                <label class="col-form-label">Jenis Group</label>
                <select class="form-select" data-control="select2" name="jenis_kendali" id="jenis_kendali" {{$data['otoritas']}} >
                  @foreach ($master['jenis-kendali'] as $key => $value)
                  <option value="{{$value->id}}" @if(!empty($data['kendali-detil'])) @if($data['kendali-detil']->fid_jenis_kendali==$value->id) selected @endif @endif >{{$value->jenis_kendali}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group mb-5">
                <label class="col-form-label">Tujuan Disposisi</label>
                <select class="form-select" data-control="select2" name="tujuan_disposisi" {{$data['otoritas']}}>
                  @foreach ($master['tujuan-disposisi'] as $key => $value)
                  <option value="{{$value->id}}" @if(!empty($data['disposisi-detil'])) @if($data['disposisi-detil']->fid_tujuan==$value->id) selected  @endif  @endif>{{$value->nama}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group mb-5">
                <label class="col-form-label">Tujuan Revisi</label>
                <select class="form-select" data-control="select2" name="tujuan_revisi" {{$data['otoritas']}}>
                  @foreach ($master['tujuan-revisi'] as $key => $value)
                  <option value="{{$value->id}}" @if(!empty($data['disposisi-detil'])) @if($data['disposisi-detil']->fid_tujuan==$value->id) selected  @endif  @endif>{{$value->nama}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group mb-5">
                <label class="col-form-label">Keterangan / Catatan</label>
                <textarea class="form-control" name="catatan" style="height:100px" {{$data['otoritas']}}>@if(!empty($data['kendali-detil'])){{$data['kendali-detil']->catatan}}@endif</textarea>
              </div>
              @if(Session::get('useractive')->hak_akses!=1)
              <div class="form-group mb-5">
                <label class="col-form-label">Upload Attachment</label>
                <input type="file" class="form-control" name="attachment" {{$data['otoritas']}} >
              </div>
              <div class="form-group mb-5">
                <label class="col-form-label">Link Google Drive</label>
                <input type="text" class="form-control" name="link_attachment" id="link_attachment">
              </div>
              @endif
              <div class="form-group">
                <div class="float-end mb-5">
                  <a href="{{url('usulan')}}" class="btn btn-secondary">Tutup</a>
                  <button type="submit" class="btn btn-danger" {{$data['otoritas']}} >Simpan</button>
                </div>
              </div>
            </form>
          </div>
          {{-- end form tambah kendali --}}
          {{-- tabel kendali --}}
          <div class="col-sm-12 bg-white mt-4 row">
            <div class="table-responsive">
              <table class="table table-striped table-row-bordered align-middle gy-5 gs-7" id="tabel_satker">
                <thead class="fw-bolder">
                  <tr>
                    <th data-priority="1">No</th>
                    <th>Tanggal / Jenis Kendali</th>
                    <th>Catatan</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="main-bdy" class="fw-bold">
                  @foreach ($data['kendali'] as $key => $value)
                  <tr>
                    <td style="width:1px;white-space:nowrap">{{$key+1}}</td>
                    <td>
                      <span style="font-size:12px;font-style:italic">{{tgl_indo($value->tanggal)}}, {{dateFormat($value->tanggal,'H:i:s')}}</span>
                      <hr  class="less-margin">
                      {!!$value->perintah!!}
                    </td>
                    <td width="200px">@if(!empty($value->catatan)){{$value->catatan}}@else Tidak Ada Catatan @endif</td>
                    <td style="width:1px;white-space:nowrap">
                      @if(Session::get('useractive')->hak_akses == "5" AND $data['produk']->fid_status == "9")
                          @if(!empty($value->attachment))
                          <a disabled target="_BLANK" class="btn btn-success btn-icon" ><i class="fa fa-download"></i></a>
                          @else
                          <a disabled class="btn btn-success btn-icon" disabled ><i class="fa fa-download"></i></a>
                          @endif
                      @else
                          @if(!empty($value->attachment))
                          <a href="https://view.officeapps.live.com/op/embed.aspx?src={{asset('storage/'.$value->attachment)}}" target="_BLANK" class="btn btn-success btn-icon"><i class="fa fa-search"></i></a>
                          <a href="{{asset('storage/'.$value->attachment)}}" target="_BLANK" class="btn btn-success btn-icon"><i class="fa fa-download"></i></a>
                          @else
                          <a href="{{ $value->link_attachment }}" class="btn btn-success btn-icon" disabled ><i class="fa fa-download"></i></a>
                          @endif
                      @endif
                      <a @if($value->fid_asal==$user->id) href="{{url('usulan/form?tab=detail&id='.$id.'&detailkendali='.$value->id)}}" @else disabled @endif class="btn btn-primary btn-icon" ><i class="fa fa-edit"></i></a>
                      <a @if($value->fid_asal==$user->id) href="javascript:;" onclick="confirmDelete('{{$value->id}}')"  @else disabled @endif  class="hapus-produk-hukum btn btn-danger btn-icon"><i class="fa fa-trash"></i></a>
                      <form action="{{url('usulan/kendali/proses')}}" method="post" id="hapus{{$value->id}}">
                        {{ csrf_field()}}
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id_usulan" value="{{$id}}">
                        <input type="hidden" name="id" value="{{$value->id}}">
                      </form>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          {{-- end tabel kendali --}}
        </div>
        {{-- end kendali usulan --}}
        {{-- lampiran --}}
        <div class="col-md-6">
          <div class="row">
            <div class="col-sm-6">
              <h3>Lampiran</h3>
            </div>
            <div class="col-sm-6">
              <button class="btn float-end btn-danger" onclick="hidelampiran()">
                <i class="fa fa-plus-square text-white text-active-primary"></i>  
                Tambah Lampiran
              </button>
            </div>
          </div>
          {{-- form tambah lampiran --}}
          @php
              if(!empty(request()->query('detaillampiran'))){
                $display = "";
              }else{
                $display = "none";
              }
          @endphp
          <div class="col-sm-12 bg-light mt-4 row" id="lampiran" style="display:{{ $display }}">
            <label class="col-form-label text-black">{{(!empty($data['lampiran-detil']) ? 'Edit' : 'Tambah')}} Lampiran</label>
            <form class="row" action="{{url('usulan/lampiran/proses')}}" method="POST" enctype="multipart/form-data" >
              {{ csrf_field() }}
              <input type="hidden" name="id_usulan" value="{{$id}}">
              <input type="hidden" name="id" value="{{$id_lampiran}}">
              <input type="hidden" name="id_uploader" value="{{Session::get('useractive')->id}}">
              <input type="hidden" name="action" value="{{(!empty($data['lampiran-detil']) ? 'edit' : 'add')}}">
              <div class="form-group mb-5">
                <label class="col-form-label">Judul Lampiran</label>
                <input type="text" name="judul" value="{{(!empty($data['lampiran-detil']) ? $data['lampiran-detil']->judul : '' )}}" class="form-control">
              </div>
              <div class="form-group mb-5">
                <label class="col-form-label">Attachment Lampiran</label>
                <input type="file" name="attachment" class="form-control">
              </div>
              <div class="form-group mb-5">
                <label class="col-form-label">Link Upload (Google Drive/Dropbox/dll)</label>
                <input type="text" class="form-control" name="link_attachment" id="link_attachment">
              </div>
              <div class="form-group mb-5">
                <label class="col-form-label">Keterangan</label>
                <textarea class="form-control" name="keterangan">{{(!empty($data['lampiran-detil']) ? $data['lampiran-detil']->keterangan : '' )}}</textarea>
              </div>
              <div class="form-group">
                <div class="float-end mb-5">
                  <a href="{{url('usulan')}}" class="btn btn-secondary">Tutup</a>
                  <button type="submit" class="btn btn-danger">Simpan</button>
                </div>
              </div>
            </form>
          </div>
          {{-- end form tambah lampiran --}}
          {{-- table lampiran --}}
          <div class="col-sm-12 bg-white mt-4 row">
            <div class="table-responsive">
              <table class="table table-striped table-row-bordered align-middle gy-5 gs-7" id="tabel_satker">
                <thead class="fw-bolder">
                  <tr>
                    <th data-priority="1">No</th>
                    <th>Judul Lampiran</th>
                    <th>Keterangan</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="main-bdy" class="fw-bold">
                  @foreach ($data['lampiran'] as $key => $value)
                  @php
                    if(Session::get('useractive')->id==$value->id_uploader){
                        $otoritas_lampiran='';
                    }
                    else{
                      $otoritas_lampiran='disabled';
                    }
                  @endphp
                    <tr>
                      <td style="width:1px;white-space:nowrap">{{$key+1}}</td>
                      <td><b>{{$value->uploader}}</b> mengunggah Lampiran <hr style="margin:5px;">{{$value->judul}}</td>
                      <td width="200px">@if(!empty($value->keterangan)){{$value->keterangan}}@else Tidak Ada Keterangan @endif</td>
                      <td style="width:1px;white-space:nowrap">
                          @if(Session::get('useractive')->hak_akses == "5" AND $data['produk']->fid_status == "9")
                            @if (!empty($value->attachment))
                            <a disabled target="_BLANK" class="btn btn-success btn-icon" ><i class="fa fa-download"></i></a>
                            @else
                            <a disabled target="_BLANK" class="btn btn-success btn-icon" ><i class="fa fa-download"></i></a>
                            @endif
                          @else
                            @if (!empty($value->attachment))
                            <a href="https://docs.google.com/viewer?url={{asset('storage/'.$value->attachment)}}" target="_BLANK" class="btn btn-success btn-icon" ><i class="fa fa-download"></i></a>
                            @else
                            <a href="{{$value->link_attachment}}" target="_BLANK" class="btn btn-success btn-icon" ><i class="fa fa-download"></i></a>
                            @endif
                          @endif
                        
                        <a @if(Session::get('useractive')->id==$value->id_uploader) href="{{url('usulan/form?tab=detail&id='.$id.'&detaillampiran='.$value->id)}}" @else disabled @endif class="btn btn-primary btn-icon" ><i class="fa fa-edit"></i></a>
                        
                        @if(Session::get('useractive')->hak_akses == "4")
                        <a href="javascript:;" onclick="confirmDelete('{{$value->id}}')" class="hapus-produk-hukum btn btn-danger btn-icon"><i class="fa fa-trash"></i></a>
                        @else
                        <a @if(Session::get('useractive')->id==$value->id_uploader) href="javascript:;" onclick="confirmDelete('{{$value->id}}')" @else disabled @endif class="hapus-produk-hukum btn btn-danger btn-icon"><i class="fa fa-trash"></i></a>
                        @endif
                        <form action="{{url('usulan/lampiran/proses')}}" method="post" id="hapus{{$value->id}}">
                          {{ csrf_field()}}
                          <input type="hidden" name="action" value="delete">
                          <input type="hidden" name="id_usulan" value="{{$id}}">
                          <input type="hidden" name="id" value="{{$value->id}}">
                        </form>
                        <form action="{{url('usulan/lampiran/proses')}}" method="post">
                            {{csrf_field()}}
                          <input type="hidden" name="action" value="setujui">
                          <input type="hidden" name="id_usulan" value="{{$id}}">
                          <input type="hidden" name="id" value="{{$value->id}}">
                          @if(Session::get('useractive')->hak_akses==2)
                          @if($value->setujui==0)
                          <button type="submit" class="btn btn-success">Setujui</button>
                          @else
                          <button type="submit" class="btn btn-danger">Batal Setujui</button>
                          @endif
                          @endif
                        </form>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          {{-- end table lampiran --}}
        </div>
        {{-- end lampiran --}}
      </div>
    </div>
  </div>
</div>