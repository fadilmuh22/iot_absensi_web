<?php

namespace App\Http\Controllers;

use App\Exports\AbsenExport;
use App\Mail\EventMail;
use App\Models\Absen;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class EventController extends Controller
{
    public function createToken($event_id)
    {
        $absen = Absen::where("user_id", Auth::id())
            ->where("event_id", $event_id)->get();
        if ($absen->isEmpty()) {
            $newAbsen = Absen::create([
                'user_id' => Auth::id(),
                'event_id' => $event_id,
            ]);
            $event = Event::find($event_id);
            $qrCode = \QrCode::format('png')->size(200)->generate(json_encode(['user_id' => Auth::id(), 'event_id' => $event_id]));
            Mail::to(Auth::user()->email)->send(new EventMail(Auth::user(), $event, $qrCode));
            return redirect('/home')->with('status', "Token berhasil dibuat dan dikirim ke email");
        }
        return redirect('/home')->with('status', "Token telah dibuat");
    }

    public function resendToken($event_id)
    {
        $event = Event::find($event_id);
        $qrCode = \QrCode::format('png')->size(200)->generate(json_encode(['user_id' => Auth::id(), 'event_id' => $event_id]));
        Mail::to(Auth::user()->email)->send(new EventMail(Auth::user(), $event, $qrCode));
        return redirect('/home')->with('status', "Token berhasil dikirim ulang ke email");
    }

    public function absen(Request $request)
    {
        $absen = Absen::where("user_id", $request->user_id)
            ->where("event_id", $request->event_id)->limit(1);

        if ($absen) {
            $absen->update([
                'hadir' => true,
                'waktu_hadir' => now(),
            ]);

            return true;
        }
        return false;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.event.index');
    }

    public function dataTables()
    { //::whereDate('tanggal', '>=', now()
        return DataTables::of(Event::query())
            ->addColumn('edit_url', function ($row) {
                return url('admin/event/edit/' . $row->event_id);
            })
            ->addColumn('delete_url', function ($row) {
                return url('admin/event/delete/' . $row->event_id);
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.event.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'required|string',
            'tempat' => 'required|string',
            'tanggal' => 'required|date_format:Y-m-d H:i:s',
            'durasi' => 'required|integer',
        ]);
        $event = Event::create($request->except('_token'));

        return redirect('/admin/event')->with('status', 'Berhasil membuat event');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($event_id)
    {
        $data['event'] = Event::find($event_id);
        return view('admin.event.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $event_id)
    {
        $validate = $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'required|string',
            'tempat' => 'required|string',
            'tanggal' => 'required|date_format:Y-m-d H:i:s',
            'durasi' => 'required|integer',
        ]);
        $event = Event::where('event_id', $event_id)->update($request->except('_token', '_method'));

        return redirect('/admin/event')->with('status', 'Berhasil mengubah event');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($event_id)
    {
        $event = Event::find($event_id);
        $event->delete();

        return redirect('/admin/event')->with('status', 'Berhasil menghapus event');
    }

    public function exportAbsens($event_id)
    {
        // $data = DB::table('events')
        //     ->select([
        //         'users.name',
        //         'hadir',
        //         'waktu_hadir'
        //     ])
        //     ->where('events.event_id', $event_id)
        //     ->join('absens', function ($join) {
        //         $join->on('absens.event_id', '=', 'events.event_id');
        //     })
        //     ->join('users', function ($join) {
        //         $join->on('users.user_id', '=', 'absens.user_id');
        //     })->get();

        // return response()->json($data);
        return Excel::download(new AbsenExport($event_id), 'absen.xlsx');
    }
}
