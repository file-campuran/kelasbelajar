@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Kelas</a></li>
    <li class="breadcrumb-item active" aria-current="page">Video Conference</li>
  </ol>
</nav>

<div class="alert alert-primary " role="alert">
  <h4 class="alert-heading">Info!</h4>
  <p>E-Meet Video Conference dalam KelasKITA memungkinkan Anda melakukan virtual meeting dengan seluruh Siswa yang tergabung dalam kelas secara Gratis dan tanpa batasan waktu</p>
</div>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-baseline mb-2">
          <h6 class="card-title mb-0">Video Conference MIPA X-MIPA-1_MIPA Biologi</h6>
          <div class="dropdown mb-2">
            <button type="button" class="btn btn-outline-success add add-meeting" data-target="#TambahData">Buat Room Virtual Meeting</button>
            <button type="button" class="btn btn-outline-danger" onclick="showSwal('passing-parameter-execute-cancel')">Cetak Excel</button>
          </div>
        </div>
        <div class="table-responsive">
          <table id="dataTableExample" class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama Meeting</th>
                <th>Kode</th>
                <th>Pertemuan</th>
                <th>Tanggal Meeting</th>
                <th>Selesai</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($meets as $item)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->code }}</td>
                    <td>Pertemuan ke-{{ $item->pertemuan }}</td>
                    <td>{{ $item->date_start }}</td>
                    <td>{{ $item->date_end == '' ? '-' : $item->date_end }}</td>
                    <td>
                        @if (is_null($item->date_end))
                            <a href="{{ route('join-meeting-room', ['code' => $item->code]) }}" class="btn btn-outline-success">Join</a>
                            <a href="#" onclick="editData('{{ $item->id }}')" class="btn btn-outline-primary edit">Edit</a>
                            <a href="#" onclick="deleteData('{{ $item->id }}')" class="btn btn-outline-danger">Delete</a>
                        @endif
                    </td>
                  </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="TambahData" tabindex="-1" role="dialog" aria-labelledby="TambahDataLabel" aria-hidden="true"  >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title title" id="exampleModalLabel">Form Pembuatan Virtual Meeting</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <input type="hidden" name="max_pertemuan_count" value="{{ $pertemuan->pertemuan }}">
        <form method="POST" action="" id="addMeet">
            @csrf
            <div class="form-group">
              <label for="recipient-name">Kapan E-meet Virtual Meeting akan dibuka ?</label>
              <input type="date" class="form-control" name="date_start" id="date_start" required>
              {{-- <div class="input-group date datepicker" id="datePickerExample">
              </div> --}}
            </div>
            <div class="form-group">
              <label for="message-text">Berikan Nama atau Judul Virtual Meeting Anda ?</label>
              <input id="name" class="form-control" name="name" id="name" type="text" required>
            </div>
            <div class="form-group">
              <label for="message-text">Pertemuan</label>
              <select name="pertemuan" class="form-control" id="pertemuan">
                {{-- @for($pt = 1; $pt <= $pertemuan->pertemuan; $pt++)
                  <option value="{{$pt}}">
                    Pertemuan {{$pt}}
                  </option>
                @endfor --}}
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal </button>
            <button type="submit" id="CreateMeet" class="btn btn-success">Generate Virtual Meeting</button>
          </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
    document.getElementsByClassName('add')[0].addEventListener('click', async function(){

      let minimalMeetingOpt = 1;

      document.getElementById('addMeet').setAttribute('action', '/kelas/video_conference/store');
      document.getElementById("addMeet").reset();

      const { data } = await $.ajax({
          url: `{{ route('video-conference.get-meeting') }}`,
          dataType: 'json'
      });

      $('select[name=pertemuan]').empty();

      if (data.meet?.pertemuan) minimalMeetingOpt = data.meet.pertemuan + 1;

      for (let i = minimalMeetingOpt; i <= $('input[name=max_pertemuan_count]').val(); i++) {
          $('select[name=pertemuan]').append(`
                <option value="${i}">
                    Pertemuan ${i}
                </option>
          `);
      }

      $($(this).data('target')).modal('show');

    })

   function editData(id){
     $('#TambahData form').attr('action', '/kelas/video_conference/' + id + '/update');
      $.ajax({
        url: '/kelas/video_conference/' +id+ '/show',
        method: 'get',
        dataType: 'json',
        success:function(data){
          $('#TambahData').modal('show');
          $('#name').val(data.response.name)
          $('#date_start').val(data.response.date_start)
          $('#pertemuan').val(data.response.pertemuan)
        }
      })
   }
    function deleteData(id) {
      Swal.fire({
        title: 'Apakah yakin menghapus data ini ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
          if(result.value) {
            $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
              },
              url: '/kelas/video_conference/'+id+'/delete',
              method: 'delete',
              success:function(data){
                Swal.fire({
                        title: "Success",
                        icon: "success",
                        text: data.messages,
                    }).then(function () {
                        window.location.reload();
                    });
              }
            })

          }
      })
    }
</script>
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



<!-- Jitsi Video Conference -->
{{-- <script src='https://meet.jit.si/external_api.js'></script>
<script src="https://meet.jit.si/libs/lib-jitsi-meet.min.js"></script>

<script>
  JitsiMeetJS.init();
  var connection = new JitsiMeetJS.JitsiConnection(null, null, options);
  connection.addEventListener(JitsiMeetJS.events.connection.CONNECTION_ESTABLISHED, onConnectionSuccess);
  connection.addEventListener(JitsiMeetJS.events.connection.CONNECTION_FAILED, onConnectionFailed);
  connection.addEventListener(JitsiMeetJS.events.connection.CONNECTION_DISCONNECTED, disconnect);

  connection.connect();

  room = connection.initJitsiConference("conference1", confOptions);
room.on(JitsiMeetJS.events.conference.TRACK_ADDED, onRemoteTrack);
room.on(JitsiMeetJS.events.conference.CONFERENCE_JOINED, onConferenceJoined);

JitsiMeetJS.createLocalTracks().then(onLocalTracks);

document.getElementById("CreateMeet").onclick =  room.join();


</script> --}}

