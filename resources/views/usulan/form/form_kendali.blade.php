<div class="row">
    <div class="col-md-6">
        <h4 style="margin:0px">Belum Dikerjakan</h4>
        <hr style="margin:0px;margin-bottom:6%;">
        {{-- <button class="btn btn-danger" onclick="hide()"><i class="icon-add"></i> Tambah Kendali</button><br> --}}
        <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Tanggal / Jenis Kendali</th>
                <th>Catatan</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data['kendali-belum'] as $key => $value)
                <tr>
                  <td style="width:1px;white-space:nowrap">{{$key+1}}</td>
                  <td>
                    <span style="font-size:12px;font-style:italic">{{tgl_indo($value->tanggal)}}, {{dateFormat($value->tanggal,'H:i:s')}}</span>
                    <hr  class="less-margin">
                    {!!$value->perintah!!}
                  </td>
                  <td width="200px">@if(!empty($value->catatan)){{$value->catatan}}@else Tidak Ada Catatan @endif</td>
                  <td style="width:1px;white-space:nowrap">
                    @if(!empty($value->attachment))
                    <a href="https://docs.google.com/viewer?url={{asset('storage/'.$value->attachment)}}" target="_BLANK" class="btn btn-success btn-xs" ><i class="icon-download"></i></a>
                    @else
                    <a href="" class="btn btn-success btn-xs" disabled ><i class="icon-download"></i></a>
                    @endif
                        </td>
                </tr>
              @endforeach
            </tbody>
          </table>
    </div>
    <div class="col-md-6">
        <h4 style="margin:0px">Sudah Dikerjakan</h4>
        <hr style="margin:0px">
        <button class="btn btn-danger" onclick="hide()"><i class="icon-add"></i> Tambah Kendali</button><br>
         @php
             if(!empty(request()->query('kendali'))){
               $display = "";
             }else{
               $display = "none";
             }
         @endphp
  <!--start -->
        <div id="toHide" style="display:{{ $display }}">
        <div style="background:#e9e9e9;padding:20px">
          <h5 style="margin-top:0px;margin-bottom:20px">{{(!empty($data['kendali-detil']) ? 'Edit' : 'Tambah')}} Kendali Usulan</h5>
          <form action="{{url('usulan/kendali/proses')}}" method="POST" enctype="multipart/form-data" >
          {{ csrf_field() }}
          <div class="form-group">
            <label>Jenis Kendali</label>
            <select class="select2" name="jenis_kendali" id="jenis_kendali" {{$data['otoritas']}} >
              @foreach ($master['jenis-kendali'] as $key => $value)
              <option value="{{$value->id}}" @if(!empty($data['kendali-detil'])) @if($data['kendali-detil']->fid_jenis_kendali==$value->id) selected @endif @endif >{{$value->jenis_kendali}}</option>
              @endforeach
            </select>
          </div>
          <div id="tujuan_disposisi">
            <div class="form-group">
              <label>Tujuan Disposisi</label>
              <select class="select2" name="tujuan_disposisi" {{$data['otoritas']}}>
                @foreach ($master['tujuan-disposisi'] as $key => $value)
                <option value="{{$value->id}}" @if(!empty($data['disposisi-detil'])) @if($data['disposisi-detil']->fid_tujuan==$value->id) selected  @endif  @endif>{{$value->nama}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div id="tujuan_revisi">
            <div class="form-group">
              <label>Tujuan Revisi</label>
              <select class="select2" name="tujuan_revisi" {{$data['otoritas']}}>
                @foreach ($master['tujuan-revisi'] as $key => $value)
                <option value="{{$value->id}}" @if(!empty($data['disposisi-detil'])) @if($data['disposisi-detil']->fid_tujuan==$value->id) selected  @endif  @endif>{{$value->nama}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label>Keterangan / Catatan</label>
            <textarea class="form-control" name="catatan" style="height:100px" {{$data['otoritas']}}>@if(!empty($data['kendali-detil'])){{$data['kendali-detil']->catatan}}@endif</textarea>
          </div>
          @if(Session::get('useractive')->hak_akses!=1)
          <div class="form-group">
            <label>Upload Attachment</label>
            <input type="file" class="dropify" name="attachment" {{$data['otoritas']}} >
          </div>
          @endif
          <input type="hidden" name="id_usulan" value="{{$id}}">
          <input type="hidden" name="id" value="{{$id_kendali}}">
          <input type="hidden" name="action" value="{{(!empty($data['kendali-detil']) ? 'edit' : 'add')}}">
          <div class="text-right">
            <a href="{{url('usulan')}}" class="btn btn-default">Tutup</a>
            <button type="submit" class="btn btn-warning" {{$data['otoritas']}} >Simpan</button>
          </div>
          </form>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
          <tr>
            <th>No</th>
            <th>Tanggal / Jenis Kendali</th>
            <th>Catatan</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data['kendali-selesai'] as $key => $value)
            <tr>
              <td style="width:1px;white-space:nowrap">{{$key+1}}</td>
              <td>
                <span style="font-size:12px;font-style:italic">{{tgl_indo($value->tanggal)}}, {{dateFormat($value->tanggal,'H:i:s')}}</span>
                <hr  class="less-margin">
                {!!$value->perintah!!}
              </td>
              <td width="200px">@if(!empty($value->catatan)){{$value->catatan}}@else Tidak Ada Catatan @endif</td>
              <td style="width:1px;white-space:nowrap">
                @if(!empty($value->attachment))
                <a href="https://docs.google.com/viewer?url={{asset('storage/'.$value->attachment)}}" target="_BLANK" class="btn btn-success btn-xs" ><i class="icon-download"></i></a>
                @else
                <a href="" class="btn btn-success btn-xs" disabled ><i class="icon-download"></i></a>
                @endif
                        <a @if($value->fid_asal==$user->id) href="{{url('usulan/form?tab=kendali&id='.$id.'&kendali='.$value->id)}}" @else disabled @endif class="btn btn-primary btn-xs" ><i class="icon-pencil7"></i></a>
                <a @if($value->fid_asal==$user->id) href="javascript:;" onclick="confirmDelete('{{$value->id}}')"  @else disabled @endif  class="hapus-produk-hukum btn btn-danger btn-xs"><i class="icon-trash"></i></a>
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