<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $primaryKey = 'event_id';

    protected $fillable = [
        "nama",
        "deskripsi",
        "tempat",
        "tanggal",
        "durasi",
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function absen()
    {
        return $this->hasMany('App\Models\Absen');
    }
}
