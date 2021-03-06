@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Kelas 
    
    </a></li>
    <li class="breadcrumb-item active" aria-current="page">Absensi Kelas</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-baseline mb-2">
          <h6 class="card-title mb-0">Absensi Kelas MIPA X-MIPA-1_MIPA Biologi</h6>
          <div class="dropdown mb-2">
                        <a href="{{url('rekap_absen_excel')}}">
                
                     
            <button type="submit" class="btn btn-outline-success">Rekap Absensi Kelas</button>

</a>
          </div>
        </div>
        <div class="table-responsive">
          <table id="dataTableExample" class="table">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <?php
                  $maxDays = date('t');
                  $currentMonth = date('F');

                  for($i=1; $i <= 16; $i++) {

                    echo "<th>Pertemuan $i</th>";
                  }
                
                ?>
              </tr>
            </thead>
            <tbody>
                  @foreach($daftar_kelas as $index => $row) 
                    <tr>
                      <td>
                        {{$index + 1}}
                      </td>

                      <td>
                        {{$row->user_detail->name}}
                      </td>
                      @for($pt = 1; $pt <= $kelas_mapel->pertemuan; $pt++) 
                        <td>
                        <!-- {{$row->kelas->jadwal_pelajaran}} -->
                        <!-- {{$row->kelas->jadwal_pelajaran->first()->id}} -->
                        <!-- {{$row->absen_by_pertemuan($row->kelas->jadwal_pelajaran->first()->id,$pt)}} -->
                        @if($row->absen_by_pertemuan($pt))
                          <span class="text-green-400">
                            Hadir
                          </span>
                        @else
                          <span>
                            -
                          </span>
                        @endif

                        </td>
                      @endfor
                    </tr>
                  @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
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