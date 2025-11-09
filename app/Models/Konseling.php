<?php

namespace App\Models;

use App\Models\Traits\HasEncryptedAttributes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Konseling extends Model
{
    use HasFactory, HasEncryptedAttributes, Notifiable;

    protected $fillable = [
        'siswa_id',
        'guru_bk_id',
        'jenis_konseling',
        'topik',
        'deskripsi',
        'tanggal',
        'waktu',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function guru_bk()
    {
        return $this->belongsTo(User::class, 'guru_bk_id');
    }
}