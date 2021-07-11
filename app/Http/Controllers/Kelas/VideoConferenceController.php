<?php

namespace App\Http\Controllers\Kelas;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Auth;
use App\Model\Absen;
use App\Model\MasterJadwalPelajaran;
use DB;
use App\Model\Meet;
use Carbon\Carbon;

class VideoConferenceController extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function VideoConferenceGet(Request $request)
    {
        $kelasMapel = MasterJadwalPelajaran::with([
            'penilaian_pengetahuan.tugas_pengetahuan' => function ($q) use ($request) {
                $q->where('user_id', '=', $request->user()->id);
            },
            'penilaian_keterampilan.tugas_keterampilan' => function ($q) use ($request) {
                $q->where('user_id', '=', $request->user()->id);
            }
        ])->where([
            ['hapus', '=', 0],
            ['id', '=', $request->session()->get('kelas_mapel')]
        ])->first();

        $data = [
            'meets' => Meet::where('class_id', $request->session()->get('kelas_id'))->get(),
            'pertemuan' => $kelasMapel
        ];
        return view('pages.kelas.videoconference', $data);
    }

    public function store(Request $request)
    {
        Meet::create([
            'class_id' => $request->session()->get('kelas_id'),
            'mapel_id' => $request->session()->get('kelas_mapel'),
            'name' => $request->name,
            'pertemuan' => $request->pertemuan,
            'code' => strtoupper(\generateRandomString(15)),
            'date_start' => date('Y-m-d', strtotime($request->date_start))
        ]);
        return redirect('kelas/video_conference');
    }

    public function destroy($id)
    {
        Meet::destroy($id);
    }

    public function show($id)
    {
        if (\Request::ajax()) {
            $meet = Meet::find($id);
            return \response()->json(['response' => $meet], 200);
        } else {
            abort(403);
        }
    }

    public function update(Request $request, $id)
    {
        Meet::where('id', $id)->update([
            'name' => $request->name,
            'pertemuan' => $request->pertemuan,
            'date_start' => date('Y-m-d', strtotime($request->date_start))
        ]);
        return redirect('kelas/video_conference');
    }
}
