<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AbsenExport implements FromCollection, WithHeadings
{
    public $event_id;

    public function __construct($event_id)
    {
        $this->event_id = $event_id;
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Hadir',
            'Waktu Hadir',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return DB::table('events')
            ->select([
                'users.name',
                'hadir',
                'waktu_hadir'
            ])
            ->where('events.event_id', $this->event_id)
            ->join('absens', function ($join) {
                $join->on('absens.event_id', '=', 'events.event_id');
            })
            ->join('users', function ($join) {
                $join->on('users.user_id', '=', 'absens.user_id');
            })->get();
    }
}
