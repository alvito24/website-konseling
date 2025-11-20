<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasEncryptedAttributes;

class Jurnal extends Model
{
    use HasEncryptedAttributes;

    protected $fillable = [
        'user_id',
        'description',
    ];

    protected $encryptable = [
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
