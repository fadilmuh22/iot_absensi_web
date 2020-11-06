<?php

namespace App\Http\Controllers;

use App\Mail\EventMail;
use App\Models\Absen;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EventController extends Controller
{
    public function createToken($event_id)
    {
        $absen = Absen::where("user_id", Auth::id())
            ->where("event_id", $event_id);
        if ($absen) {
            $newAbsen = Absen::create([
                'user_id' => Auth::id(),
                'event_id' => $event_id,
            ]);
            $qrCode = \QrCode::format('png')->size(200)->generate(json_encode(['user_id' => Auth::id(), 'event_id' => $event_id]));
            Mail::to(Auth::user()->email)->send(new EventMail(Auth::user(), $qrCode));
            return redirect('/home')->with('status', "Token berhasil dibuat dan dikirim ke email");
        }
        return redirect('/home')->with('status', "Token sudah dikirim");
    }

    public function resendToken($event_id)
    {
        $qrCode = \QrCode::format('png')->size(200)->generate(['user_id' => Auth::id(), 'event_id' => $event_id]);
        Mail::to(Auth::user()->email)->send(new EventMail(Auth::user(), $qrCode));
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
        $events = Event::whereDate('tanggal', '>=', now());

        return $events;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return dd($request->all());
        $validate = $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'required|string',
            'tempat' => 'required|string',
            'tanggal' => 'required|date',
            'tanggal' => 'required|integer',
        ]);
        $event = Event::create($request->all());

        return redirect('/event')->with('status', 'Berhasil membuat event');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
