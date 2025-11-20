<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Jadwal extends Model
{
    use HasUuids;

    protected $fillable = [
        'guru_id',
        'day',
        'start_time',
        'end_time',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
