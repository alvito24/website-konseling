<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffRef extends Model
{
    protected $table = 'staff_ref';
    
    protected $fillable = [
        'nip',
        'name',
        'position'
    ];
}