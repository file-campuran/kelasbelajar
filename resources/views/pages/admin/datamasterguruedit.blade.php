@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
     <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Penilaian Pengetahuan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

        <form method="POST" action="{{ url('Data_Master_Guru', $guru->id)}}">
        {{ method_field('PATCH')}}

        @csrf
      <div class="modal-body">
      <div class="form-group row">
         <div class="col-lg-3">
           <label class="col-form-label">Nip</label>
         </div>
         <div class="col-lg-8">
           <input type="text" value="{{$guru->nisn_or_nip}}" class="form-control" name="nip">
         </div>
       </div>
       <div class="form-group row">
         <div class="col-lg-3">
           <label class="col-form-label">Nama</label>
         </div>
         <div class="col-lg-8">
           <input type="text" value="{{$guru->name}}" class="form-control" name="nama">
         </div>
       </div>
       <div class="form-group row">
         <div class="col-lg-3">
           <label class="col-form-label">Tempat Lahir</label>
         </div>
         <div class="col-lg-8">
           <input type="text" value="{{$guru->tempat_lahir}}" class="form-control" name="tempat_lahir">
         </div>
       </div>
       <div class="form-group row">
         <div class="col-lg-3">
           <label class="col-form-label">Tanggal Lahir</label>
         </div>
         <div class="col-lg-8">
           <input type="date" class="form-control" value="{{$guru->tanggal_lahir}}" name="tanggal_lahir">
         </div>
       </div>
       <div class="form-group row">
         <div class="col-lg-3">
           <label class="col-form-label">Email</label>
         </div>
         <div class="col-lg-8">
           <input type="email" class="form-control" value="{{$guru->email}}" name="email">
         </div>
       </div>
       <div class="form-group row">
         <div class="col-lg-3">
           <label class="col-form-label">Jenis Kelamin</label>
         </div>
         <div class="col-lg-8">
          <select name="jenis_kelamin" value="{{$guru->jenis_kelamin}}" class="form-control">
            <option value="laki-laki">laki-laki</option>
            <option value="perempuan">perempuan</option>
          </select>
         </div>
       </div>
       <div class="form-group row">
         <div class="col-lg-3">
           <label class="col-form-label">Tahun Masuk</label>
         </div>
         <div class="col-lg-8">
          <input type="text" value="{{$guru->tahun_masuk}}" name="tahun_masuk" class="form-control">
         </div>
       </div>

       <div class="form-group row">
         <div class="col-lg-3">
           <label class="col-form-label">Mapel Kelas Ajar</label>
         </div>
         <div class="col-lg-8">
          <select name="mapel_id" id="">
            @foreach($mapel as $key => $mapel)
              <option value="{{$mapel->id}}">
                {{$mapel->nama_mapel}}
              </option>
            @endforeach
          </select>
         </div>
       </div>
      <div class="modal-footer">
           <a href="{{url('dashboard')}}">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal </button>
        </a>
        <button type="submit" class="btn btn-primary">Tambah</button>
      </div>

      </form>
    </div>

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script src="{{ asset('assets/js/datepicker.js') }}"></script>
  <script src="{{ asset('assets/js/timepicker.js') }}"></script>
@endpush