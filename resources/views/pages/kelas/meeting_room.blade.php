@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Kelas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Meeting Room</li>
        </ol>
    </nav>

    @if($meet->date_end != null)
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body text-center">
                        <h4 class="h4 mb-4">Video Conference Telah Selesai</h4>
                        <img class="mx-auto mb-3" src="{{ asset('assets/images/undraw_business_chat_ldig.svg') }}" alt="No Meeting Image" width="400">
                        <p class="mt-3">Video conference ini diakhiri pada tanggal {{ $meet->date_end->format('d-m-Y') }}</p>
                        <a href="javascript:window.history.go(-1)" class="btn btn-primary mt-3">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    @elseif ($meet->date_start->isToday())
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h1>Meeting {{ $meet->code }}</h1>
                        <div class="d-block text-white text-center mt-3" id="jitsi-meet-parent-el" style="height: 74vh; width: 100%;"></div>
                    </div>
                    @if (auth()->user()->userDetail->role->name_role === 'guru')
                        <div class="card-footer text-right">
                            <button class="btn btn-danger purge-all">Kosongkan Room & Akhiri Meeting</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body text-center">
                        <h4 class="h4 mb-4">Bukan Jadwal Video Conference</h4>
                        <img class="mx-auto mb-3" src="{{ asset('assets/images/undraw_business_chat_ldig.svg') }}" alt="No Meeting Image" width="400">
                        <p class="mt-3">Video conference ini dijadwalkan untuk tanggal {{ $meet->date_start->format('d-m-Y') }}</p>
                        <a href="javascript:window.history.go(-1)" class="btn btn-primary mt-3">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
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
    <script src="{{ asset('assets/js/jitsi_external_api.js') }}"></script>
    @if ($meet->date_start->isToday() && $meet->date_end == null)
        <script>
            const domain = 'meet.jit.si';
            const options = {
                roomName: '{{ $meet->code }}',
                width: '100%',
                height: '100%',
                parentNode: document.querySelector('#jitsi-meet-parent-el'),
                disableInviteFunctions: true,
                inviteDomain: 'asd',
                configOverwrite: {
                    startsWithAudioMuted: true,
                    disableKick: true,
                },
                userInfo: {
                    email: '{{ auth()->user()->userDetail->email }}',
                    displayName: '{{ auth()->user()->userDetail->name }}',
                }
            };
            const api = new JitsiMeetExternalAPI(domain, options);
            @if(auth()->user()->userDetail->role->name_role === 'guru')
                $('.purge-all').on('click', async function() {
                    const { value } = await Swal.fire({
                        title: 'Apakah yakin akhiri meeting ini ?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Konfirmasi'
                    });
                    if (value) {
                        console.log(api.getParticipantsInfo());
                        for (const participant of api.getParticipantsInfo()) {
                            if (participant.displayName != options.userInfo.displayName) {
                                api.executeCommand('kickParticipant', participant.participantId)
                            }
                        }
                        const { status } = await $.ajax({
                            url: '{{ route("end-meeting-room", ["code" => $meet->code]) }}',
                            dataType: 'json'
                        });
                        if (status === 'success') {
                            api.executeCommand('hangup');
                            window.location.href = '{{ route("video-conference.get") }}';
                        }
                        // alert('Loop all to kick members and end meeting');
                    }
                });
            @endif
        </script>
    @endif
@endpush
