<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
        $data['todayEvents'] = Event::whereDate('tanggal', '=', now())->limit(3)->get();
        $data['registeredEvents'] = DB::table('absens')
            ->select('events.*')
            ->join('events', 'events.event_id', '=', 'absens.event_id')
            ->where('absens.user_id', Auth::id())
            ->whereDate('events.tanggal', '>=', now())
            ->limit(3)
            ->get();
        return view('home', $data);
    }

    public function events(Request $request)
    {
        $data['events'] = DB::table('events')
            ->select([
                'events.*',
                'absens.event_id as absen_event_id',
                'absens.user_id as absen_user_id',
                'hadir',
                'waktu_hadir',
            ]);

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
        $data['event'] = Event::find($event_id);
        return view('event', $data);
    }
}
