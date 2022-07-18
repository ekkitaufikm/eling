<div class="row">
  <div class="col-md-6">
  </div>
  
  <div class="col-md-6">
    <h1 style="margin:0px">Lampiran</h1>
    <hr style="margin:0px">
    <button class="btn btn-danger" onclick="hidelampiran()"><i class="icon-add"></i> Tambah Lampiran</button><br>
    @php
        if(!empty(request()->query('lampiran'))){
          $display = "";
        }else{
          $display = "none";
        }
    @endphp
    <div id="lampiran" style="display:{{ $display }}">
    <div style="background:#e9e9e9;padding:20px">
      <h5 style="margin-top:0px;margin-bottom:20px">{{(!empty($data['lampiran-detil']) ? 'Edit' : 'Tambah')}} Lampiran</h5>
      <form action="{{url('usulan/lampiran/proses')}}" method="POST" enctype="multipart/form-data" >
        {{ csrf_field() }}
        <div class="form-group">
          <label>Judul Lampiran</label>
          <input type="text" name="judul" value="{{(!empty($data['lampiran-detil']) ? $data['lampiran-detil']->judul : '' )}}" class="form-control">
        </div>
        <div class="form-group">
          <label>Attachment Lampiran</label>
          <input type="file" name="attachment" class="dropify">
        </div>
        <div class="form-group">
          <label>Keterangan</label>
          <textarea class="form-control" name="keterangan">{{(!empty($data['lampiran-detil']) ? $data['lampiran-detil']->keterangan : '' )}}</textarea>
        </div>
        <input type="hidden" name="id_usulan" value="{{$id}}">
        <input type="hidden" name="id" value="{{$id_lampiran}}">
        <input type="hidden" name="id_uploader" value="{{Session::get('useractive')->id}}">
        <input type="hidden" name="action" value="{{(!empty($data['lampiran-detil']) ? 'edit' : 'add')}}">
        <div class="text-right">
          <a href="{{url('usulan')}}" class="btn btn-default">Tutup</a>
          <button type="submit" class="btn btn-warning" >Simpan</button>
        </div>
      </form>
    </div>
    </div>
    <br>  
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>No</th>
          <th>Judul Lampiran</th>
          <th>Keterangan</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
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
              <a href="https://docs.google.com/viewer?url={{asset('storage/'.$value->attachment)}}" target="_BLANK" class="btn btn-success btn-xs" ><i class="icon-download"></i></a>
              <a @if(Session::get('useractive')->id==$value->id_uploader) href="{{url('usulan/form?tab=lampiran&id='.$id.'&lampiran='.$value->id)}}" @else disabled @endif class="btn btn-primary btn-xs" ><i class="icon-pencil7"></i></a>
              <a @if(Session::get('useractive')->id==$value->id_uploader) href="javascript:;" onclick="confirmDelete('{{$value->id}}')" @else disabled @endif class="hapus-produk-hukum btn btn-danger btn-xs"><i class="icon-trash"></i></a>
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
