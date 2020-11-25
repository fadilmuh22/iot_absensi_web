<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['todayEvents'] = DB::table('events')
            ->select([
                'events.*',
                'absens.absen_id',
                'absens.event_id as absen_event_id',
                'absens.user_id as absen_user_id',
                'hadir',
                'waktu_hadir',
            ])
            ->whereDate('tanggal', '=', now())
            ->limit(3)
            ->orderBy('tanggal')
            ->leftJoin('absens', function ($join) {
                $join->on('events.event_id', '=', 'absens.event_id')->where('absens.user_id', Auth::id());
            })->get();
        $data['registeredEvents'] = DB::table('absens')
            ->select([
                'events.*',
                'absens.absen_id',
                'absens.user_id as absen_user_id',
            ])
            ->join('events', 'events.event_id', '=', 'absens.event_id')
            ->where('absens.user_id', Auth::id())
            ->whereDate('events.tanggal', '>=', now())
            ->limit(3)
            ->orderBy('tanggal')
            ->get();
        return view('home', $data);
    }

    public function events(Request $request)
    {
        $data['events'] = DB::table('events')
            ->select([
                'events.*',
                'absens.absen_id',
                'absens.event_id as absen_event_id',
                'absens.user_id as absen_user_id',
                'hadir',
                'waktu_hadir',
            ])
            ->orderBy('tanggal');

        if ($request->query('today', false)) {
            $data['events'] = $data['events']->whereDate('events.tanggal', '>=', now());
        }

        if ($request->query('registered', false)) {
            $data['events'] = $data['events']->join('absens', 'events.event_id', '=', 'absens.event_id');
            $data['events'] = $data['events']->where('absens.user_id', Auth::id());
        } else {
            $data['events'] = $data['events']->leftJoin('absens', function ($join) {
                $join->on('events.event_id', '=', 'absens.event_id')->where('absens.user_id', Auth::id());
            });
        }
        // $data['events'] = $data['events']->get();
        // return response()->json($data);

        $data['events'] = $data['events']->paginate(10);
        return view('events', $data);
    }

    public function event($event_id)
    {
        $data['event'] = DB::table('events')
            ->select([
                'events.*',
                'absens.absen_id',
                'absens.event_id as absen_event_id',
                'absens.user_id as absen_user_id',
                'hadir',
                'waktu_hadir',
            ])
            ->where('events.event_id', $event_id)
            ->leftJoin('absens', function ($join) {
                $join->on('events.event_id', '=', 'absens.event_id')->where('absens.user_id', Auth::id());
            })
            ->limit(1)
            ->get()[0];
        return view('event', $data);
    }

    public function absenDelete(Request $request)
    {
        if (Auth::id() == $request->user_id) {
            $absen = Absen::find($request->absen_id);
            $absen->delete();

            return redirect('/home')->with('status', 'Berhasil menghapus absen event');
        }
        return redirect('/home')->with('status', 'Tidak terotentikasi');
    }

    public function resetPassword(Request $request)
    {
        $user = User::find(Auth::id());
        $user->password = bcrypt($request->password);
        $user->save();


        return redirect('/admin')->with('status', 'Berhasil mereset password');
    }
}
