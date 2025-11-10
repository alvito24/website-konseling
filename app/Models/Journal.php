<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Journal extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id','user_id','encrypted_content','visibility','mood'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->id)) $model->id = (string) Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // helper to create encrypted entry
    public static function createEncrypted($userId, $plainContent, $visibility = 'private', $mood = null)
    {
        $enc = encrypt($plainContent); // global helper uses APP_KEY (same as Crypt)
        return self::create([
            'user_id' => $userId,
            'encrypted_content' => $enc,
            'visibility' => $visibility,
            'mood' => $mood,
        ]);
    }
}
