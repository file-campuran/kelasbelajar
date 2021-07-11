<?php

namespace App\Http\Controllers\Kelas;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Auth;
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
        $data = [
            'meets' => Meet::where('class_id', $request->session()->get('kelas_id'))->get()
        ];
        return view('pages.kelas.videoconference', $data);
    }

    public function store(Request $request)
    {
        Meet::create([
            'class_id' => $request->session()->get('kelas_id'),
            'mapel_id' => $request->session()->get('kelas_mapel'),
            'name' => $request->name,
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
            'date_start' => date('Y-m-d', strtotime($request->date_start))
        ]);
        return redirect('kelas/video_conference');
    }

    public function meetingRoom($code)
    {
        $meet = Meet::where('code', $code)->first();

        if (!$meet) return abort(400, 'Kode meeting "' . $code . '" tidak ditemukan');

        $meet->date_start = Carbon::parse($meet->date_start);
        $meet->date_end = $meet->date_end ? Carbon::parse($meet->date_end) : null;

        return view('pages.kelas.meeting_room', compact('meet'));
    }

    public function endMeetingRoom($code)
    {
        $meet = Meet::where('code', $code)->first();
        $meet->date_end = Carbon::now();
        $meet->save();
        return response()->json(['status' => 'success', 'meet_code' => $meet->code]);
    }
}
