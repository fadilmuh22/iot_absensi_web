<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;

    protected $primaryKey = 'absen_id';

    protected $fillable = [
        "user_id",
        "event_id",
        "hadir",
        "waktu_hadir",
    ];

    public function event()
    {
        return $this->belongsTo('App\Models\Event');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
