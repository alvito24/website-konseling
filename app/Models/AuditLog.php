<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $table = 'audit_logs';
    
    protected $fillable = [
        'user_id',
        'action',
        'description',
        'ip_address',
        'user_agent',
        'target_type',
        'target_id',
        'meta',
        'ip',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}